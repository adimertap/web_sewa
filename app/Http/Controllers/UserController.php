<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Alert;
use App\Http\Requests\UserRequest;
use App\Models\Seksi;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    try {
      $user = User::with('Seksi')->get();
      $seksi = Seksi::where('status', 'A')->get();

      return view('pages.Master.User.user', compact('user', 'seksi'));
    } catch (\Throwable $th) {
      return $th;
      Alert::warning('Warning', 'Internal Server Error, Data Not Found');
      return redirect()->back();
    }
  }

  public function myprofile()
  {
    try {
      $user = User::find(Auth::user()->id);
      if (!$user) {
        Alert::warning('Warning', 'Internal Server Error, Data Not Found');
        return redirect()->back();
      }
      $tr = Transaksi::where('user_id', Auth::user()->id)->orderBy('transaksi_id', 'DESC')->get();

      $countPending = Transaksi::where('user_id', Auth::user()->id)->where('transaksi_status', 'Pending')->where('transaksi_type', 'Checkout')->count();
      $countApproved = Transaksi::where('user_id', Auth::user()->id)->where('transaksi_status', 'Approved')->where('transaksi_type', 'Checkout')->count();
      $countReject = Transaksi::where('user_id', Auth::user()->id)->where('transaksi_status', 'Reject')->where('transaksi_type', 'Checkout')->count();
      $countSelesai = Transaksi::where('user_id', Auth::user()->id)->where('transaksi_status', 'Selesai')->where('transaksi_type', 'Checkout')->count();

      return view('pages.profile.myprofile', compact('user', 'tr', 'countPending', 'countApproved', 'countReject', 'countSelesai'));
    } catch (\Throwable $th) {
      Alert::warning('Warning', 'Internal Server Error, Data Not Found');
      return redirect()->back();
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
  public function store(UserRequest $request)
  {
    try {
      DB::beginTransaction();

      $item = new User();
      $item->name = $request->name;
      $item->email = $request->email;
      $item->password = Hash::make($request->password_user);
      $item->phone_number = $request->phone_number ?? null;
      $item->seksi_id = $request->seksi_id;
      $item->role = $request->role;
      $item->active = 'A';
      $item->save();
      DB::commit();

      Alert::success('Success', 'Data User Berhasil Ditambahkan');
      return redirect()->back();
    } catch (\Throwable $th) {
      return $th;
      DB::rollBack();
      Alert::warning('Warning', 'Internal Server Error');
      return redirect()->back();
    }
  }

  public function change_password(Request $request)
  {
    try {
      $request->validate([
        'password_user' => 'required|min:5', // Adjust the minimum length as needed
        'confirm_password' => 'required|same:password_user',
      ]);

      DB::beginTransaction();
      $item = User::find($request->userIdPass);
      $item->password = Hash::make($request->password_user);
      $item->update();

      DB::commit();
      Alert::success('Success', 'Change Password Berhasil
            ');
      return redirect()->back();
    } catch (\Throwable $th) {
      DB::rollBack();
      Alert::warning('Warning', $th->getMessage());
      return redirect()->back();
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    try {
      $item = User::with('Seksi')->find($id);
      if (!$item) {
        return 404;
      }
      return $item;
    } catch (\Throwable $th) {
      Alert::warning('Warning', 'Internal Server Error, Data Not Found');
      return redirect()->back();
    }
  }


  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    try {
      $user = User::with('Seksi')->find($id);
      $tr = Transaksi::where('user_id', $id)->orderBy('transaksi_id', 'DESC')->get();

      $countPending = Transaksi::where('user_id', $id)->where('transaksi_status', 'Pending')->where('transaksi_type', 'Checkout')->count();
      $countApproved = Transaksi::where('user_id', $id)->where('transaksi_status', 'Approved')->where('transaksi_type', 'Checkout')->count();
      $countReject = Transaksi::where('user_id', $id)->where('transaksi_status', 'Reject')->where('transaksi_type', 'Checkout')->count();
      $countSelesai = Transaksi::where('user_id', $id)->where('transaksi_status', 'Selesai')->where('transaksi_type', 'Checkout')->count();

      return view('pages.Master.User.detail', compact('user', 'tr', 'countPending', 'countApproved', 'countReject', 'countSelesai'));
    } catch (\Throwable $th) {
      return $th;
      Alert::warning('Warning', 'Internal Server Error, Data Not Found');
      // return redirect()->back();
    }
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    try {
      DB::beginTransaction();
      $item = User::find($id);
      $item->name = $request->name;
      $item->email = $request->email;
      $item->phone_number = $request->phone_number;
      $item->seksi_id = $request->seksi_id;
      $item->role = $request->role;
      $item->update();
      DB::commit();

      Alert::success('Success', 'Data User Diupdate');
      return redirect()->back();
    } catch (\Throwable $th) {
      return $th;
      DB::rollBack();
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

      $item = User::find($id);
      $item->delete();
      DB::commit();

      Alert::success('Success', 'Data User Berhasil Terhapus');
      return redirect()->back();
    } catch (\Throwable $th) {
      DB::rollBack();
      Alert::warning('Warning', 'Internal Server Error');
      return redirect()->back();
    }
  }
}
