<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Alert;
use App\Models\Opname;
use App\Models\Seksi;
use Barryvdh\DomPDF\Facade as PDF;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class TransaksiController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    try {
      $query = Transaksi::query();

      if (Auth::user()->role == 'User') {
        $query->where('user_id', Auth::user()->id);
      }

      if ($request->has('statusFilter') && !empty($request->statusFilter)) {
        $query->where('transaksi_status', $request->statusFilter);
      }

      // if ($request->has('userFilter') && !empty($request->userFilter)) {
      //   $query->where('user_id', $request->userFilter);
      // }

      if ($request->has('seksiFilter') && !empty($request->seksiFilter)) {
        $query->where('seksi_id', $request->seksiFilter);
      }
      // Apply month filter only if it's not empty
      if ($request->has('monthFilter') && !empty($request->monthFilter)) {
        $query->whereMonth('created_at', $request->monthFilter);
      }

      // Apply year filter only if it's not empty
      if ($request->has('yearFilter') && !empty($request->yearFilter)) {
        $query->whereYear('created_at', $request->yearFilter);
      }

      // dd($query->toSql(), $query->getBindings());
      $tr = $query->where('transaksi_type', 'Checkout')->with('Detail', 'User', 'User.Seksi')->orderBy('transaksi_id', 'DESC')->get();

      if (Auth::user()->role == 'User') {
        $pendingCount = Transaksi::where('transaksi_status', 'Pending')->where('user_id', Auth::user()->id)->where('transaksi_type', 'Checkout')->count();
        $approveCount = Transaksi::where('transaksi_status', 'Approved')->where('user_id', Auth::user()->id)->where('transaksi_type', 'Checkout')->count();
        $selesaiCount = Transaksi::where('transaksi_status', 'Selesai')->where('user_id', Auth::user()->id)->where('transaksi_type', 'Checkout')->count();
        $rejectCount = Transaksi::where('transaksi_status', 'Reject')->where('user_id', Auth::user()->id)->where('transaksi_type', 'Checkout')->count();
      } else {
        $pendingCount = Transaksi::where('transaksi_status', 'Pending')->where('transaksi_type', 'Checkout')->count();
        $approveCount = Transaksi::where('transaksi_status', 'Approved')->where('transaksi_type', 'Checkout')->count();
        $selesaiCount = Transaksi::where('transaksi_status', 'Selesai')->where('transaksi_type', 'Checkout')->count();
        $rejectCount = Transaksi::where('transaksi_status', 'Reject')->where('transaksi_type', 'Checkout')->count();
      }

      $user = User::where('role', 'User')->where('active', 'A')->get();
      $seksi = Seksi::where('status', 'A')->get();
      return view('pages.Transaksi.list', compact('seksi', 'tr', 'pendingCount', 'approveCount', 'selesaiCount', 'rejectCount', 'user'));
    } catch (\Throwable $th) {
      return $th;
    }
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    try {
      $seksi = Seksi::get();
      $barang = Barang::where('active', 'A')->where('status', '!=', 'Habis')->get();

      return view('pages.Transaksi.tambah', compact('barang', 'seksi'));
    } catch (\Throwable $th) {
      return $th;
    }
  }

  public function cetak($id)
  {
    try {

      $tr = Transaksi::with(['User', 'Detail.Barang', 'User.Seksi'])->findOrFail($id);
      $admin = Auth::user(); // Assuming admin is the logged-in user

      return view('pages.Transaksi.print', compact('tr', 'admin'));
    } catch (\Throwable $th) {
      return $th;
    }
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    try {
      $monthYear = date('m-Y'); // Get the current month and year
      $today = date('d/m/Y');

      if ($request->seksi) {
        $findSeksi = Seksi::where('seksi_id', $request->seksi)->first();
      }

      $getTransaksi = Transaksi::where('jenis_transaksi', 'Keluar')
        ->orderBy('transaksi_id', 'DESC')
        ->first();
      if (!$getTransaksi) {
        $lastId = 0;
      } else {
        $lastId = $getTransaksi->transaksi_id + 1;
      }


      DB::beginTransaction();
      $header = new Transaksi();
      $header->transaksi_code = "RK-" . $findSeksi->seksi_kode . "-" . $today . "-" . $lastId;
      $header->user_id = Auth::user()->id;
      $header->seksi_id = $request->seksi;
      $header->seksi_kode = $findSeksi->seksi_kode ?? '';
      $header->transaksi_status = "Pending";
      $header->transaksi_date = Date::now();
      $header->jenis_transaksi = 'Keluar';
      $header->transaksi_type = 'Checkout';
      $header->total_qty = 0;
      $header->save();

      $items = $request->input('items');
      $totalBarang = 0;
      foreach ($items as $item) {
        $findBarang = Barang::where('barang_code', $item['barang_code'])->where('active', 'A')->first();
        if (!$findBarang) {
          return response()->json([
            'message' => 'Barang Not Found!'
          ], 404);
        }
        $details = new DetailTransaksi(); // Assuming you have a details model
        $details->transaksi_id = $header->transaksi_id;
        $details->barang_id = $findBarang->barang_id;
        $details->qty = $item['qty'];;
        $details->save();

        $totalBarang += 1;
      }

      $updateHeader = Transaksi::find($header->transaksi_id);
      $updateHeader->total_qty = $totalBarang;
      $updateHeader->update();

      DB::commit();
      return response()->json([
        'message' => 'Transaction successful!',
        'redirect_url' => route('transaksi.index') // Change to your success route
      ], 200);
    } catch (\Exception $e) {
      DB::rollBack();
      return response()->json([
        'message' => 'Transaction failed! ' . $e->getMessage()
      ], 500);
    }
  }

  public function approve($id)
  {
    try {
      DB::beginTransaction();
      $tr = Transaksi::find($id);
      if (!$tr) {
        Alert::warning('Warning', 'Data not found');
        return redirect()->back();
      }
      $tr->transaksi_status = 'Approved';
      $tr->approved_by = Auth::user()->id;
      $tr->update();

      // $details = DetailTransaksi::where('transaksi_id', $id)->get();
      // if ($details->isEmpty()) {
      //     return; // Exit the function if there are no details
      // }

      // // Loop through each detail in the collection
      // foreach ($details as $item) {
      //     $barang = Barang::where('barang_id', $item->barang_id)->first();
      //     if (!$barang) continue;

      //     $op = new Opname();
      //     $op->transaksi_id = $id;
      //     $op->user_id = $tr->user_id;
      //     $op->barang_id = $item->barang_id;
      //     $op->stok_awal = $barang->qty;
      //     $op->tanggal = $tr->transaksi_date;

      //     if ($tr->jenis_transaksi == 'Masuk') {
      //         $op->qty_masuk = $item->qty;
      //         $op->stok_akhir = $barang->qty + $item->qty;
      //         $op->status = 'Masuk';
      //         $barang->qty += $item->qty;
      //     } else {
      //         $op->qty_keluar = $item->qty;
      //         $op->stok_akhir = $barang->qty - $item->qty;
      //         $op->status = 'Keluar';
      //         $barang->qty -= $item->qty;
      //     }
      //     $op->save();
      //     if ($barang->qty >= $barang->min_qty) {
      //         $barang->status = 'Cukup';
      //     } else if ($barang->qty > 0) {
      //         $barang->status = 'Hampir Habis';
      //     } else {
      //         $barang->status = 'Habis';
      //     }
      //     $barang->save();
      // }

      DB::commit();
      Alert::success('Success', 'Data Bon Barang Berhasil Diapprove');
      return redirect()->back();
    } catch (\Throwable $th) {
      DB::rollBack();
      Alert::warning('Warning', 'Internal Server Error');
      return redirect()->back();
    }
  }

  public function selesai($id)
  {
    try {
      DB::beginTransaction();
      $tr = Transaksi::find($id);
      if (!$tr) {
        Alert::warning('Warning', 'Data not found');
        return redirect()->back();
      }
      $tr->transaksi_status = 'Approved';
      $tr->update();

      $details = DetailTransaksi::where('transaksi_id', $id)->get();
      if ($details->isEmpty()) {
        return; // Exit the function if there are no details
      }

      // Loop through each detail in the collection
      foreach ($details as $item) {
        $barang = Barang::where('barang_id', $item->barang_id)->first();
        if (!$barang) continue;

        $op = new Opname();
        $op->transaksi_id = $id;
        $op->user_id = $tr->user_id;
        $op->barang_id = $item->barang_id;
        $op->stok_awal = $barang->qty;
        $op->tanggal = $tr->transaksi_date;

        if ($tr->jenis_transaksi == 'Masuk') {
          $op->qty_masuk = $item->qty;
          $op->stok_akhir = $barang->qty + $item->qty;
          $op->status = 'Masuk';
          $barang->qty += $item->qty;
        } else {
          $op->qty_keluar = $item->qty;
          $op->stok_akhir = $barang->qty - $item->qty;
          $op->status = 'Keluar';
          $barang->qty -= $item->qty;
        }
        $op->save();
        if ($barang->qty >= $barang->min_qty) {
          $barang->status = 'Cukup';
        } else if ($barang->qty > 0) {
          $barang->status = 'Hampir Habis';
        } else {
          $barang->status = 'Habis';
        }
        $barang->save();
      }

      DB::commit();
      Alert::success('Success', 'Data Bon Barang Berhasil Terselesaikan, Cek Kembali Stok Opname');
      return redirect()->back();
    } catch (\Throwable $th) {
      DB::rollBack();
      Alert::warning('Warning', 'Internal Server Error');
      return redirect()->back();
    }
  }

  public function reject(Request $request, $id)
  {
    try {
      DB::beginTransaction();
      $tr = Transaksi::find($id);
      if (!$tr) {
        Alert::warning('Warning', 'Data not found');
        return redirect()->back();
      }
      $tr->transaksi_status = 'Reject';
      $tr->keterangan = $request->keteranganReject;
      $tr->approved_by = Auth::user()->id;
      $tr->update();
      DB::commit();

      Alert::success('Success', 'Data Bon Barang Berhasil DiReject');
      return redirect()->back();
    } catch (\Throwable $th) {
      DB::rollBack();
      Alert::warning('Warning', 'Internal Server Error');
      return redirect()->back();
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    try {
      $tr = Transaksi::with('Detail', 'User', 'User.Seksi', 'ApprovedBy')->find($id);
      $admin = User::where('role', 'Admin')->first();
      if (!$tr) {
        Alert::warning('Warning', 'Data not Found, Conflict');
        return redirect()->back();
      }
      return view('pages.Transaksi.preview', compact('tr', 'admin'));
    } catch (\Throwable $th) {
      Alert::warning('Warning', 'Internal Server Error');
      return redirect()->back();
    }
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    try {
      $tr = Transaksi::with('Detail', 'Detail.Barang', 'User', 'User.Seksi')->find($id);
      if (!$tr) {
        Alert::warning('Warning', 'Data not Found, Conflict');
        return redirect()->back();
      }
      $seksi = Seksi::get();
      $barang = Barang::where('active', 'A')->where('status', '!=', 'Habis')->get();
      return view('pages.Transaksi.edit', compact('tr', 'seksi', 'barang'));
    } catch (\Throwable $th) {
      Alert::warning('Warning', 'Internal Server Error');
      return redirect()->back();
    }
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    try {
      if ($request->seksi) {
        $findSeksi = Seksi::where('seksi_id', $request->seksi)->first();
      }
      DB::beginTransaction();
      $header = Transaksi::find($id);
      if (!$header) {
        return response()->json([
          'message' => 'Transaksi Not Found!'
        ], 404);
      }
      $header->seksi_id = $request->seksi;
      $header->seksi_kode = $findSeksi->seksi_kode ?? '';
      $header->total_qty = 0;
      $header->save();

      $items = $request->input('items');
      $totalBarang = 0;
      DetailTransaksi::where('transaksi_id', $header->transaksi_id)->delete();
      foreach ($items as $item) {
        $findBarang = Barang::where('barang_code', $item['barang_code'])->where('active', 'A')->first();
        if (!$findBarang) {
          return response()->json([
            'message' => 'Barang Not Found!'
          ], 404);
        }
        $details = new DetailTransaksi(); // Assuming you have a details model
        $details->transaksi_id = $header->transaksi_id;
        $details->barang_id = $findBarang->barang_id;
        $details->qty = $item['qty'];;
        $details->save();
        $totalBarang += 1;
      }

      $updateHeader = Transaksi::find($header->transaksi_id);
      $updateHeader->total_qty = $totalBarang;
      $updateHeader->update();

      DB::commit();
      return response()->json([
        'message' => 'Transaction successful!',
        'redirect_url' => route('transaksi.index') // Change to your success route
      ], 200);
    } catch (\Exception $e) {
      DB::rollBack();
      return response()->json([
        'message' => 'Transaction failed! ' . $e->getMessage()
      ], 500);
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    try {
      DB::beginTransaction();
      $tr = Transaksi::find($id);
      if (!$tr) {
        Alert::warning('Warning', 'Internal Server Error');
        return redirect()->back();
      }
      $tr->delete();
      DB::commit();

      Alert::success('Success', 'Data Bon Barang Berhasil Dihapus');
      return redirect()->back();
    } catch (\Throwable $th) {
      DB::rollBack();
      Alert::warning('Warning', 'Internal Server Error');
      return redirect()->back();
    }
  }
}
