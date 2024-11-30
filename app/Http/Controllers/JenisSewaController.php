<?php

namespace App\Http\Controllers;

use App\Models\JenisSewa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Alert;

class JenisSewaController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    try {
      $jenis = JenisSewa::get();
      return view('pages.Master.sewa', compact('jenis'));
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
    try {
      DB::beginTransaction();

      $item = new JenisSewa();
      $item->jenis_nama = $request->jenis_nama;
      $item->active = 'A';
      $item->save();
      DB::commit();

      Alert::success('Success', 'Data Jenis Berhasil Ditambahkan');
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
      $item = JenisSewa::find($id);
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
      $item = JenisSewa::find($id);
      $item->jenis_nama = $request->jenis_nama;
      $item->update();
      DB::commit();

      Alert::success('Success', 'Data Jenis Diupdate');
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

      $item = JenisSewa::find($id);
      $item->delete();
      DB::commit();

      Alert::success('Success', 'Data Jenis Berhasil Terhapus');
      return redirect()->back();
    } catch (\Throwable $th) {
      DB::rollBack();
      Alert::warning('Warning', 'Internal Server Error');
      return redirect()->back();
    }
  }
}
