<?php

namespace App\Http\Controllers;

use Alert;
use App\Models\JenisSewa;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
  public function dashboard()
  {
    try {
      $jenis = JenisSewa::get();
      $countSewaSebagian = Transaksi::where('jenis_id', 1)->count();
      $countRestitusi = Transaksi::where('jenis_id', 2)->count();
      $countSudahDiputus = Transaksi::where('jenis_id', 3)->count();
      $countBelumTuntas = Transaksi::where('jenis_id', 4)->count();
      $countKerjasama = Transaksi::where('jenis_id', 5)->count();
      $countSudahBayarBatal = Transaksi::where('jenis_id', 6)->count();
      $datas = Transaksi::with('Jenis', 'SistemBayar', 'Nomor')->where('status', 'A')->orderBy('transaksi_id', 'DESC')->get();



      $now = date('Y-m-d'); // Get the current date as 'YYYY-MM-DD'
      $jatuhTempo = Transaksi::where('jatuh_tempo_pembayaran', $now)->get();
      $countJatuhTempo = $jatuhTempo->count();

      return view('dashboard', compact(
        'jenis',
        'datas',
        'countSewaSebagian',
        'countRestitusi',
        'countSudahDiputus',
        'countBelumTuntas',
        'countKerjasama',
        'countSudahBayarBatal',
        'countJatuhTempo',
        'jatuhTempo'
      ));
    } catch (\Throwable $th) {
      return $th;
    }
  }
}
