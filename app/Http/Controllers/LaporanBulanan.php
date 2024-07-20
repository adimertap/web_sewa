<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Seksi;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanBulanan extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {

    $query = Transaksi::selectRaw(
      'mst_seksi.seksi_name as seksi, tr_transaksi.seksi_id as seksi_id, COUNT(tr_transaksi.transaksi_id) as jumlah_transaksi,
      DATE_FORMAT(tr_transaksi.transaksi_date, "%M") as month,
      YEAR(tr_transaksi.transaksi_date) as year'
    )->leftJoin('mst_seksi', 'tr_transaksi.seksi_id', '=', 'mst_seksi.seksi_id')
      ->where('tr_transaksi.jenis_transaksi', 'Keluar')
      ->groupBy('year', 'month', 'seksi', 'seksi_id');

    // Apply filters based on request
    if ($request->filled('seksiFilter')) {
      $query->where('tr_transaksi.seksi_id', $request->seksiFilter);
    }
    if ($request->filled('monthFilter')) {
      $query->whereRaw('DATE_FORMAT(tr_transaksi.transaksi_date, "%m") = ?', [$request->monthFilter]);
    }
    if ($request->filled('yearFilter')) {
      $query->whereYear('tr_transaksi.transaksi_date', $request->yearFilter);
    }

    $tr = $query->orderBy('year', 'DESC')
      ->orderBy('month', 'DESC')
      ->get();

    $seksi = Seksi::get();
    return view('pages.Laporan.bulanan', compact('tr', 'seksi'));
  }

  public function getDetail($month, $year, $seksi)
  {
    try {
      $monthNumber = Carbon::parse($month)->month;

      $detail = DB::table('det_transaksi')
        ->leftJoin('tr_transaksi', 'det_transaksi.transaksi_id', '=', 'tr_transaksi.transaksi_id')
        ->leftJoin('mst_barang', 'det_transaksi.barang_id', '=', 'mst_barang.barang_id')
        ->selectRaw('mst_barang.barang_code as code, mst_barang.barang_name as name, SUM(det_transaksi.qty) as total, mst_barang.satuan as satuan')
        ->whereMonth('tr_transaksi.transaksi_date', $monthNumber)
        ->whereYear('tr_transaksi.transaksi_date', $year)
        ->where('tr_transaksi.seksi_id', $seksi)
        ->groupBy('mst_barang.barang_code', 'mst_barang.barang_name', 'mst_barang.satuan')
        ->get();

      $detailAll = DB::table('det_transaksi')
        ->leftJoin('tr_transaksi', 'det_transaksi.transaksi_id', '=', 'tr_transaksi.transaksi_id')
        ->leftJoin('mst_barang', 'det_transaksi.barang_id', '=', 'mst_barang.barang_id')
        ->selectRaw('mst_barang.barang_code as barang_code, mst_barang.barang_name as barang_name, det_transaksi.qty as total, mst_barang.satuan as satuan, tr_transaksi.transaksi_date as tanggal, tr_transaksi.transaksi_code as code, tr_transaksi.transaksi_id as transaksi_id')
        ->whereMonth('tr_transaksi.transaksi_date', $monthNumber)
        ->whereYear('tr_transaksi.transaksi_date', $year)
        ->where('tr_transaksi.seksi_id', $seksi)
        ->get();

      $seksiname = Seksi::where('seksi_id', $seksi)->first();

      return view('pages.Laporan.detail', compact('detail', 'seksiname', 'month', 'year', 'detailAll'));
    } catch (\Throwable $th) {
      return $th;
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
