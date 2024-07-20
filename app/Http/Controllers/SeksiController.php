<?php

namespace App\Http\Controllers;


use App\Http\Requests\SeksiRequest;
use App\Models\Seksi;
use Illuminate\Http\Request;
use Alert;
use Illuminate\Support\Facades\DB;

class SeksiController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    try {
      $seksi = Seksi::orderBy('seksi_kode', 'ASC')->get();
      return view('pages.Master.seksi', compact('seksi'));
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
  public function store(Request $request)
  {
    try {
      $check = Seksi::where('seksi_kode', $request->kode)->first();
      if (!$check) {
        DB::beginTransaction();

        $item = new Seksi();
        $item->seksi_kode = $request->kode;
        $item->seksi_name = $request->name;
        $item->status = 'A';
        $item->save();
        DB::commit();

        Alert::success('Success', 'Data Jenis Berhasil Ditambahkan');
        return redirect()->back();
      } else {
        Alert::warning('Warning', 'Kode Tersebut Telah Ada');
        return redirect()->back();
      }
    } catch (\Throwable $th) {
      DB::rollBack();
      Alert::warning('Warning', 'Internal Server Error');
      return redirect()->back();
    }
  }

  /**
   * Display the specified resource.
   */
  public function show($id)
  {
    try {
      $item = Seksi::find($id);
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
  public function edit(Seksi $seksi)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $id)
  {
    try {
      DB::beginTransaction();
      $item = Seksi::find($request->seksiId);
      $item->seksi_kode = $request->kode;
      $item->seksi_name = $request->name;
      $item->update();
      DB::commit();
      Alert::success('Success Title', 'Data Seksi Diupdate');
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
  public function destroy($id)
  {
    try {
      DB::beginTransaction();

      $item = Seksi::find($id);
      $item->delete();
      DB::commit();

      Alert::success('Success Title', 'Data Seksi Berhasil Terhapus');
      return redirect()->back();
    } catch (\Throwable $th) {
      DB::rollBack();
      Alert::warning('Warning', 'Internal Server Error');
      return redirect()->back();
    }
  }
}
