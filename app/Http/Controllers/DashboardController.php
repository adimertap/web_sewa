<?php

namespace App\Http\Controllers;

use Alert;
use App\Models\JenisSewa;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
      $datas = Transaksi::with('Jenis')->where('status', 'A')->orderBy('transaksi_id', 'DESC')->get();

      return view('dashboard', compact(
        'jenis',
        'datas',
        'countSewaSebagian',
        'countRestitusi',
        'countSudahDiputus',
        'countBelumTuntas',
        'countKerjasama',
        'countSudahBayarBatal'
      ));
    } catch (\Throwable $th) {
      return $th;
    }
  }
}
