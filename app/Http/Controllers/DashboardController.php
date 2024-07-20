<?php

namespace App\Http\Controllers;

use Alert;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
  public function dashboard()
  {
    try {
      if (Auth::user()->role == 'User') {
        $pendingCount = Transaksi::where('transaksi_status', 'Pending')->where('user_id', Auth::user()->id)->where('transaksi_type', 'Checkout')->count();
        $approveCount = Transaksi::where('transaksi_status', 'Approved')->where('user_id', Auth::user()->id)->where('transaksi_type', 'Checkout')->count();
        $selesaiCount = Transaksi::where('transaksi_status', 'Selesai')->where('user_id', Auth::user()->id)->where('transaksi_type', 'Checkout')->count();
        $rejectCount = Transaksi::where('transaksi_status', 'Reject')->where('user_id', Auth::user()->id)->where('transaksi_type', 'Checkout')->count();
        $tr = Transaksi::where(function ($query) {
          $query->where('transaksi_status', 'Pending')
            ->orWhere('transaksi_status', 'Reject');
        })
          ->where('user_id', Auth::user()->id)
          ->where('transaksi_type', 'Checkout')
          ->orderBy('transaksi_id', 'DESC')
          ->get();
      } else {
        $pendingCount = Transaksi::where('transaksi_status', 'Pending')->where('transaksi_type', 'Checkout')->count();
        $approveCount = Transaksi::where('transaksi_status', 'Approved')->where('transaksi_type', 'Checkout')->count();
        $selesaiCount = Transaksi::where('transaksi_status', 'Selesai')->where('transaksi_type', 'Checkout')->count();
        $rejectCount = Transaksi::where('transaksi_status', 'Reject')->where('transaksi_type', 'Checkout')->count();
        $tr = Transaksi::where('transaksi_status', 'Pending')->where('transaksi_type', 'Checkout')->orderBy('transaksi_id', 'DESC')->get();
      }
      return view('dashboard', compact('pendingCount', 'approveCount', 'selesaiCount', 'rejectCount', 'tr'));
    } catch (\Throwable $th) {
      return redirect()->route('transaksi.index');
    }
  }
}
