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

      $datas = Transaksi::with('Jenis')->orderBy('transaksi_id', 'DESC')->get();

      return view('dashboard', compact('jenis', 'datas'));
    } catch (\Throwable $th) {
      return $th;
    }
  }
}
