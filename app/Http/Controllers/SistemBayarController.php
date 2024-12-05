<?php

namespace App\Http\Controllers;

use App\Models\MasterSistemBayar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Alert;

class SistemBayarController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $sistem = MasterSistemBayar::get();
    return view('pages.Master.sistem', compact('sistem'));
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
    try {
      DB::beginTransaction();

      $item = new MasterSistemBayar();
      $item->sistem_pembayaran = $request->sistem_pembayaran;
      $item->save();
      DB::commit();

      Alert::success('Success', 'Data Sistem Berhasil Ditambahkan');
      return redirect()->back();
    } catch (\Throwable $th) {
      return $th;
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
      $item = MasterSistemBayar::find($id);
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
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    try {
      DB::beginTransaction();
      $item = MasterSistemBayar::find($id);
      $item->sistem_pembayaran = $request->sistem_pembayaran;
      $item->update();
      DB::commit();

      Alert::success('Success', 'Data Sistem Pembayaran Diupdate');
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

      $item = MasterSistemBayar::find($id);
      $item->delete();
      DB::commit();

      Alert::success('Success', 'Data Sistem Pembayaran Berhasil Terhapus');
      return redirect()->back();
    } catch (\Throwable $th) {
      DB::rollBack();
      Alert::warning('Warning', 'Internal Server Error');
      return redirect()->back();
    }
  }
}
