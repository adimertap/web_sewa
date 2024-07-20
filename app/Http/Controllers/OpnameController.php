<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Opname;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Alert;
use App\Models\DetailTransaksi;
use App\Models\Transaksi;

class OpnameController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    try {
      $query = Opname::query();

      if ($request->has('barangFilter') && !empty($request->barangFilter)) {
        $query->where('barang_id', $request->barangFilter);
      }
      if ($request->has('monthFilter') && !empty($request->monthFilter)) {
        $query->whereMonth('created_at', $request->monthFilter);
      }
      if ($request->has('yearFilter') && !empty($request->yearFilter)) {
        $query->whereYear('created_at', $request->yearFilter);
      }
      $opname = $query->with('Barang', 'Transaksi', 'User')->orderBy('transaksi_id', 'ASC')->get();
      $barang = Barang::where('active', 'A')->get();
      return view('pages.Opname.opname', compact('opname', 'barang'));
    } catch (\Throwable $th) {
      //throw $th;
    }
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    //
  }

  public function cetak(Request $request)
  {
    try {
      $query = Opname::query();

      // Filter by barangCetak if provided
      if ($request->has('barangCetak') && !empty($request->barangCetak)) {
        $query->where('barang_id', $request->barangCetak);
      }

      // Filter by jenis if provided
      if ($request->has('jenis') && !empty($request->jenis)) {
        $query->where('status', $request->jenis);
      }

      // Check if start_date and end_date are provided, then apply filtering
      if (!empty($request->start_date) && !empty($request->end_date)) {
        $query->whereBetween('tanggal', [$request->start_date, $request->end_date]);
      }

      // Fetch opname data with relationships
      $opname = $query->with('Transaksi', 'User')->get();

      // Pass opname data to the view
      return view('pages.Opname.print', compact('opname'));
    } catch (\Throwable $th) {
      return $th;
      Alert::warning('Warning', 'Internal Server Error');
      return redirect()->back();
    }
  }


  public function resetOpname()
  {
    try {
      DB::beginTransaction();
      Opname::query()->delete();
      DB::commit();
      Alert::success('Success', 'Data Stok Opname Berhasil Direset!');
      return redirect()->back();
    } catch (\Throwable $th) {
      DB::rollBack();
      Alert::warning('Warning', 'Internal Server Error');
      return redirect()->back();
    }
  }

  public function resetStok()
  {
    try {
      DB::beginTransaction();
      Barang::query()->update(['qty' => 0, 'status' => 'Habis']);
      DB::commit();
      Alert::success('Success', 'Data Stok Barang Berhasil di Reset!');
      return redirect()->back();
    } catch (\Throwable $th) {
      DB::rollBack();
      Alert::warning('Warning', 'Internal Server Error');
      return redirect()->back();
    }
  }

  public function resetTransaksi()
  {
    try {
      DB::beginTransaction();
      Transaksi::query()->delete();
      DetailTransaksi::query()->delete();
      DB::commit();
      Alert::success('Success', 'Data Transaksi Berhasil Direset!');
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
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }
}
