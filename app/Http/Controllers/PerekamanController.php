<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Alert;
use App\Models\Opname;

class PerekamanController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    try {
      // $tr_all = Transaksi::where('transaksi_type', 'Rekam')->with('Detail', 'User', 'User.Seksi')->orderBy('transaksi_id', 'DESC')->get();
      $tr = Transaksi::where('transaksi_type', 'Rekam')->where('jenis_transaksi', 'Masuk')->with('Detail', 'User', 'User.Seksi')->orderBy('transaksi_id', 'DESC')->get();
      // $tr_keluar = Transaksi::where('transaksi_type', 'Rekam')->where('jenis_transaksi', 'Keluar')->with('Detail', 'User', 'User.Seksi')->get();
      $barang = Barang::where('active', 'A')->get();

      return view('pages.Perekaman.list', compact('tr', 'barang'));
    } catch (\Throwable $th) {
      return $th;
    }
  }

  public function databarang($id)
  {
    try {
      $br = Barang::where('barang_id', $id)->first();
      if (!$br) {
        return response()->json([
          'message' => 'Barang Not Found!'
        ], 404);
      }
      return response()->json([
        'message' => 'Get Barang Success!',
        'data' => $br
      ], 200);
    } catch (\Throwable $th) {
      return response()->json([
        'message' => 'Transaction failed! ' . $th->getMessage()
      ], 500);
    }
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create(Request $request)
  {
    try {
      $jenis = $request->jenis;
      $barang = Barang::where('active', 'A')->get();
      return view('pages.Perekaman.tambah', compact('barang', 'jenis'));
    } catch (\Throwable $th) {
      //throw $th;
    }
  }

  public function cetak($id)
  {
    try {

      $tr = Transaksi::with(['User', 'Detail.Barang', 'User.Seksi'])->findOrFail($id);
      $admin = Auth::user(); // Assuming admin is the logged-in user

      return view('pages.Perekaman.print', compact('tr', 'admin'));
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
      $randomNumber = mt_rand(10000000, 99999999);
      $monthYear = date('m-Y'); // Get the current month and year
      $today = date('d/m/Y');

      $getTransaksi = Transaksi::where('jenis_transaksi', 'Masuk')
        ->orderBy('transaksi_id', 'DESC')
        ->first();
      if (!$getTransaksi) {
        $lastId = 0;
      } else {
        $lastId = $getTransaksi->transaksi_id + 1;
      }

      DB::beginTransaction();
      $header = new Transaksi();
      $header->transaksi_code = "RM-" . $today . "-" . $lastId;
      // $header->transaksi_code = "RM-" . $randomNumber . "-" . $monthYear;
      $header->user_id = Auth::user()->id;
      $header->transaksi_status = "Pending";
      $header->transaksi_date = Date::now();
      $header->jenis_transaksi = 'Masuk';
      // $header->jenis_transaksi = $request->jenis;
      $header->transaksi_type = 'Rekam';
      $header->total_qty = 0;
      $header->save();

      $items = $request->input('items');
      $totalBarang = 0;
      foreach ($items as $item) {
        $findBarang = Barang::where('barang_code', $item['barang_code'])->where('active', 'A')->first();
        if (!$findBarang) {
          continue;
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
        'redirect_url' => route('perekaman.index') // Change to your success route
      ], 200);
    } catch (\Exception $e) {
      DB::rollBack();
      return response()->json([
        'message' => 'Transaction failed! ' . $e->getMessage()
      ], 500);
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    try {
      $tr = Transaksi::with('Detail', 'User', 'User.Seksi')->find($id);
      if (!$tr) {
        Alert::warning('Warning', 'Data not Found, Conflict');
        return redirect()->back();
      }
      return view('pages.Perekaman.preview', compact('tr'));
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
      $barang = Barang::where('active', 'A')->get();
      $tr = Transaksi::with('Detail', 'Detail.Barang', 'User', 'User.Seksi')->find($id);
      if (!$tr) {
        Alert::warning('Warning', 'Data not Found, Conflict');
        return redirect()->back();
      }
      return view('pages.Perekaman.edit', compact('tr', 'barang'));
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
    //
  }

  public function confirm($id)
  {
    try {
      DB::beginTransaction();
      $tr = Transaksi::find($id);
      if (!$tr) {
        Alert::warning('Warning', 'Data not found');
        return redirect()->back();
      }
      $tr->transaksi_status = 'Selesai';
      $tr->update();

      $details = DetailTransaksi::where('transaksi_id', $id)->get();
      if ($details->isEmpty()) {
        DB::commit();
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
      Alert::success('Success', 'Rekam Berhasil Di Confirm');
      return redirect()->back();
    } catch (\Throwable $th) {
      DB::rollBack(); // Move this line before the return statement
      Alert::warning('Warning', 'Internal Server Error');
      return redirect()->back();
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
