<?php

namespace App\Http\Controllers;

use App\Models\Saran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Alert;
use PhpParser\Node\Expr\New_;

class SaranController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    if (Auth::user()->role == 'Admin') {
      $saran = Saran::with('Seksi', 'User')
        ->orderBy('saran_id', 'desc')
        ->get();

      return view('pages.Saran.index', compact('saran'));
    } else {
      return view('pages.Saran.create');
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
      $new = new Saran();
      $new->saran = $request->saran;
      $new->user_id = Auth::user()->id;
      $new->seksi_id = Auth::user()->seksi_id;
      $new->save();

      Alert::success('Success', 'Terima Kasih Atas Saran dan Masukan Anda!');
      return redirect()->back();
    } catch (\Throwable $th) {
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
