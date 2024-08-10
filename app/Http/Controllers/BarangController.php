<?php

namespace App\Http\Controllers;

use App\Http\Requests\BarangRequest;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Alert;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    try {
      $query = Barang::query();
      if ($request->has('statusFilter') && !empty($request->statusFilter)) {
        $query->where('status', $request->statusFilter);
      }
      $barang = $query->get();

      $cukup = Barang::where('status', 'Cukup')->count();
      $hampirHabis = Barang::where('status', 'Hampir Habis')->count();
      $habis = Barang::where('status', 'Habis')->count();

      // $barang = Barang::get();
      return view('pages.Master.barang', compact('barang', 'cukup', 'hampirHabis', 'habis'));
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
  public function store(BarangRequest $request)
  {
    try {
      DB::beginTransaction();
      $item = new Barang();
      $item->barang_code = $request->barang_code;
      $item->barang_name = $request->barang_name;
      $item->satuan = $request->satuan;
      $item->qty = $request->qty;
      $item->min_qty = $request->min_qty;
      if ($item->qty == 0) {
        $status = "Habis";
      } else if ($item->qty == $item->min_qty || $item->qty <= $item->min_qty) {
        $status = "Hampir Habis";
      } else {
        $status = "Cukup";
      }
      $item->status = $status;
      $item->active = $request->active;
      // if ($request->hasFile('barang_photo')) {
      //   $newImage = $request->barang_photo;
      //   $newImageName = Str::random(10) . '.' . $newImage->getClientOriginalExtension();
      //   try {
      //     Storage::disk('public')->put($newImageName, file_get_contents($newImage));
      //   } catch (\Throwable $th) {
      //     DB::rollBack();
      //     Alert::warning('Warning', 'Internal Server Error');
      //     return redirect()->back();
      //   }
      //   $item->barang_photo = $newImageName;
      // }
      if ($request->hasFile('barang_photo')) {
        $newImage = $request->file('barang_photo');
        $imageContent = file_get_contents($newImage->getRealPath());
        $base64Image = base64_encode($imageContent);
        $item->barang_photo = $base64Image; // Store base64 string in database
      }


      $item->save();
      DB::commit();

      Alert::success('Success', 'Data Barang Berhasil Ditambahkan');
      return redirect()->back();
    } catch (\Throwable $th) {
      return $th;

      DB::rollBack();
      // Alert::warning('Warning', 'Internal Server Error');
      // return redirect()->back();
    }
  }

  public function updateStok(Request $request)
  {
    try {
      $item = Barang::find($request->qbarangId);
      if (!$item) {
        Alert::warning('Warning', 'Internal Server Error');
        return redirect()->back();
      }
      DB::beginTransaction();
      $item->qty = $request->qqty;
      if ($request->qqty == 0) {
        $status = "Habis";
      } else if ($request->qqty == $item->min_qty || $request->qqty <= $item->min_qty) {
        $status = "Hampir Habis";
      } else {
        $status = "Cukup";
      }
      $item->status = $status;
      $item->update();
      DB::commit();

      Alert::success('Success', 'Data Stok Barang Berhasil Diupdate');
      return redirect()->back();
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
      $item = Barang::find($id);
      if (!$item) {
        return 404;
      }
      if ($item->barang_photo) {
        // Create a data URL for the base64 image
        $imageData = 'data:image/jpeg;base64,' . $item->barang_photo;
        $item->image_url = $imageData;
      } else {
        $item->image_url = null; // No image available
      }

      // $item->image_url = asset('storage/' . $item->barang_photo); // Generate the URL for the image
      return response()->json($item);
      // return $item;
    } catch (\Throwable $th) {
      Alert::warning('Warning', 'Internal Server Error, Data Not Found');
      return redirect()->back();
    }
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Barang $barang)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $id)
  {
    try {
      // return $request;
      DB::beginTransaction();
      $item = Barang::find($id);
      $item->barang_code = $request->barang_code;
      $item->barang_name = $request->barang_name;
      $item->satuan = $request->satuan;
      // $item->qty = $request->qty;
      $item->min_qty = $request->min_qty;
      $item->active = $request->active;
      if ($item->qty == 0) {
        $status = "Habis";
      } else if ($item->qty == $item->min_qty) {
        $status = "Hampir Habis";
      } else {
        $status = "Cukup";
      }
      $item->status = $status;
      if ($request->hasFile('barang_photo')) {
        $oldPhoto = $item->barang_photo;

        // Delete the old photo from storage
        if ($oldPhoto && Storage::disk('barang')->exists($oldPhoto)) {
          Storage::disk('barang')->delete($oldPhoto);
        }

        $newImage = $request->file('barang_photo');
        $newImageName = Str::random(10) . '.' . $newImage->getClientOriginalExtension();
        Storage::disk('barang')->put($newImageName, file_get_contents($newImage));
        $item->barang_photo = $newImageName;
        $item->barang_photo = $newImageName;
      }

      $item->update();
      DB::commit();

      Alert::success('Success', 'Data Barang Berhasil Diupdate');
      return redirect()->back();
    } catch (\Throwable $th) {
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
      $item = Barang::find($id);
      if (!$item) {
        Alert::warning('Warning', 'Internal Server Error');
        return redirect()->back();
      }
      $oldPhoto = $item->barang_photo;
      // Delete the old photo from storage
      if ($oldPhoto && Storage::disk('barang')->exists($oldPhoto)) {
        Storage::disk('barang')->delete($oldPhoto);
      }
      $item->delete();
      DB::commit();

      Alert::success('Success', 'Data Barang Berhasil Dihapus');
      return redirect()->back();
    } catch (\Throwable $th) {
      return $th;
      DB::rollBack();
      Alert::warning('Warning', 'Internal Server Error');
      return redirect()->back();
    }
  }
}
