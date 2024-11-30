<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Alert;
use Carbon\Carbon;
use App\Models\JenisSewa;
use App\Models\Kenaikan;
use App\Models\Pembayaran;
use App\Models\Transaksi;
use App\Models\TransaksiFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\TryCatch;

class SewaController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //
  }


  /**
   * Show the form for creating a new resource.
   */
  public function create(Request $request)
  {
    $query = $request->query('jenis'); // Get the 'jenis' query parameter
    $jenis = JenisSewa::find($query);
    $currentDate = Carbon::now(); // Gets the current date and time
    $dateNow = Carbon::now()->toDateString(); // Formats it to 'YYYY-MM-DD'
    if (!$jenis) {
      Alert::warning('Warning', 'Internal Server Error');
      return redirect()->back();
    }

    return view('pages.Sewa.tambah', compact('jenis', 'dateNow'));
  }

  public function TambahKenaikan(Request $request, $id)
  {
    try {
      $check = Transaksi::where('transaksi_id', $id)->first();
      if (!$check) {
        Alert::warning('Warning', 'Data tidak ditemukan');
        return redirect()->back();
      }

      $check = Kenaikan::where('transaksi_id', $id)->where('tahun_ke', $request->tahun_ke)->first();
      if ($check) {
        Alert::warning('Warning', 'Data Kenaikan Tahun tersebut sudah Ada');
        return redirect()->back();
      }
      DB::beginTransaction();
      $data = new Kenaikan();
      $data->transaksi_id = $id;
      $data->tahun_ke = $request->tahun_ke;
      $data->besaran = $request->besaran;
      $data->save();

      DB::commit();
      Alert::success('Success', 'Data Kenaikan Berhasil ditambahkan');
      return redirect()->back();
    } catch (\Throwable $th) {
      DB::rollBack();
      return $th;
    }
  }
  public function DeleteKenaikan($id)
  {
    try {
      DB::beginTransaction();
      $tr = Kenaikan::find($id);
      if (!$tr) {
        Alert::warning('Warning', 'Internal Server Error');
        return redirect()->back();
      }
      $tr->delete();
      DB::commit();

      Alert::success('Success', 'Data Kenaikan Berhasil Dihapus');
      return redirect()->back();
    } catch (\Throwable $th) {
      DB::rollBack();
      Alert::warning('Warning', 'Internal Server Error');
      return redirect()->back();
    }
  }

  public function TambahPembayaran(Request $request, $id)
  {
    try {
      $check = Transaksi::where('transaksi_id', $id)->first();
      if (!$check) {
        Alert::warning('Warning', 'Data tidak ditemukan');
        return redirect()->back();
      }

      $check = Pembayaran::where('transaksi_id', $id)->where('pembayaran_tahun', $request->pembayaran_tahun)->first();
      if ($check) {
        Alert::warning('Warning', 'Data Pembayaran Tahun tersebut sudah Ada');
        return redirect()->back();
      }
      DB::beginTransaction();
      $data = new Pembayaran();
      $data->transaksi_id = $id;
      $data->pembayaran_tahun = $request->pembayaran_tahun;
      $data->pembayaran_tanggal = $request->pembayaran_tanggal;
      $data->nominal = $request->nominal;
      $data->keterangan = $request->keterangan;
      $data->save();

      DB::commit();
      Alert::success('Success', 'Data Pembayaran Berhasil ditambahkan');
      return redirect()->back();
    } catch (\Throwable $th) {
      DB::rollBack();
      return $th;
    }
  }

  public function DeletePembayaran($id)
  {
    try {
      DB::beginTransaction();
      $tr = Pembayaran::find($id);
      if (!$tr) {
        Alert::warning('Warning', 'Internal Server Error');
        return redirect()->back();
      }
      $tr->delete();
      DB::commit();

      Alert::success('Success', 'Data Pembayaran Berhasil Dihapus');
      return redirect()->back();
    } catch (\Throwable $th) {
      DB::rollBack();
      Alert::warning('Warning', 'Internal Server Error');
      return redirect()->back();
    }
  }

  public function UpdateKenaikan(Request $request)
  {
    try {
      $tr = Kenaikan::find($request->kenaikan_id);
      if (!$tr) {
        Alert::warning('Warning', 'Internal Server Error');
        return redirect()->back();
      }

      DB::beginTransaction();
      $tr->tahun_ke = $request->tahun_ke;
      $tr->besaran = $request->besaran;
      $tr->update();
      DB::commit();

      Alert::success('Success', 'Data Kenaikan Berhasil Diupdate');
      return redirect()->back();
    } catch (\Throwable $th) {
      DB::rollBack();
      return $th;
    }
  }

  public function UpdatePembayaran(Request $request)
  {
    try {
      $tr = Pembayaran::find($request->pembayaran_id);
      if (!$tr) {
        Alert::warning('Warning', 'Internal Server Error');
        return redirect()->back();
      }

      DB::beginTransaction();
      $tr->pembayaran_tahun = $request->pembayaran_tahun;
      $tr->pembayaran_tanggal = $request->pembayaran_tanggal;
      $tr->nominal = $request->nominal;
      $tr->keterangan = $request->keterangan;
      $tr->update();
      DB::commit();

      Alert::success('Success', 'Data Pembayaran Berhasil Diupdate');
      return redirect()->back();
    } catch (\Throwable $th) {
      DB::rollBack();
      return $th;
    }
  }

  public function TambahFile(Request $request)
  {
    try {
      DB::beginTransaction();
      if ($request->hasFile('file_pendukung')) {
        foreach ($request->file('file_pendukung') as $file) {
          $fileName = $file->getClientOriginalName();
          $filePath = $file->storeAs('file_pendukung', $fileName, 'public');
          TransaksiFile::create([
            'transaksi_id' => $request->transaksi_id,
            'file_name' => $fileName,
            'path' => $filePath,
          ]);
        }
      }
      DB::commit();
      // return $request->all();
      Alert::success('Success', 'Data Berhasil ditambahkan');
      return redirect()->back();
    } catch (\Throwable $th) {
      DB::rollBack();
      return $th;
    }
  }

  public function DeleteFile($fileId)
  {
    try {
      DB::beginTransaction();
      $file = TransaksiFile::findOrFail($fileId);

      // Check if the file exists in the storage and delete it
      if (Storage::disk('public')->exists($file->path)) {
        Storage::disk('public')->delete($file->path);
      }

      // Delete the database record
      $file->delete();
      DB::commit();
      Alert::success('Success', 'Data File Dihapus');
      return redirect()->back()->with('success', 'File deleted successfully.');
    } catch (\Throwable $th) {
      DB::rollBack();
      return $th;
    }
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    try {
      $jenis = JenisSewa::where('jenis_nama', $request->jenis_id)->first();
      $findSame = Transaksi::where('nomor_perjanjian', $request->nomor_perjanjian)
        ->where('jenis_id', $jenis->jenis_id)
        ->first();
      if ($findSame) {
        Alert::warning('Warning', 'Transaksi Jenis ' . $jenis->jenis_nama . ', dengan nomor ' . $findSame->nomor_perjanjian . ' sudah ada.');
        return redirect()->back();
      }

      //Begin Transaction
      DB::beginTransaction();
      $transaksiData['lokasi'] = $request->lokasi;
      $transaksiData['nomor_perjanjian'] = $request->nomor_perjanjian;
      $transaksiData['tanggal_perjanjian'] = $request->tanggal_perjanjian;
      $transaksiData['nomor_tanggal_perjanjian'] = $request->nomor_perjanjian && $request->tanggal_perjanjian;
      $transaksiData['nomor_kode_barang'] = $request->nomor_kode_barang;
      $transaksiData['nomor_register'] = $request->nomor_register;
      $transaksiData['sertipikat'] = $request->sertipikat;
      $transaksiData['jumlah_bidang_sewa_bagian'] = $request->jumlah_bidang_sewa_bagian;
      $transaksiData['luas_total_sertipikat'] = $request->luas_total_sertipikat;
      $transaksiData['luas_yang_disewa'] = $request->luas_yang_disewa;
      $transaksiData['nama_pengguna'] = $request->nama_pengguna;
      $transaksiData['nomor_telepon'] = $request->nomor_telepon;
      $transaksiData['email'] = $request->email;
      $transaksiData['NIK'] = $request->NIK;
      $transaksiData['umur'] = $request->umur;
      $transaksiData['pekerjaan'] = $request->pekerjaan;
      $transaksiData['alamat'] = $request->alamat;
      $transaksiData['peruntukan'] = $request->peruntukan;
      $transaksiData['jangka_waktu_kerjasama'] = $request->jangka_waktu_kerjasama;
      $transaksiData['tahun_peninjauan_berikutnya'] = $request->tahun_peninjauan_berikutnya;
      $transaksiData['jumlah_bidang_sewa_keseluruhan'] = $request->jumlah_bidang_sewa_keseluruhan;
      $transaksiData['sistem_pembayaran'] = $request->sistem_pembayaran;
      $transaksiData['sistem_pembayaran_ket'] = $request->sistem_pembayaran_ket;
      $transaksiData['jangka_waktu_mulai'] = $request->jangka_waktu_mulai;
      $transaksiData['jangka_waktu_selesai'] = $request->jangka_waktu_selesai;
      $transaksiData['besar_sewa'] = $request->besar_sewa;
      $transaksiData['besar_sewa_per'] = $request->besar_sewa_per;
      $transaksiData['kontribusi_awal'] = $request->kontribusi_awal;
      $transaksiData['kabupaten'] = $request->kabupaten;
      $transaksiData['status'] = "A";
      $transaksiData['keterangan'] = $request->keterangan;
      $transaksiData['jenis_id'] = $jenis->jenis_id;

      $transaksi = Transaksi::create($transaksiData);
      foreach ($request->input('group-a') as $item) {
        Pembayaran::create([
          'transaksi_id' => $transaksi->transaksi_id,
          'pembayaran_tahun' => $item['pembayaran_tahun'],
          'nominal' => $item['nominal'],
          'pembayaran_tanggal' => $item['pembayaran_tanggal'],
          'keterangan' => $item['keterangan'],
          'status' => 'A'
        ]);
      }


      foreach ($request->input('kenaikan-a') as $item) {
        Kenaikan::create([
          'transaksi_id' => $transaksi->transaksi_id,
          'tahun_ke' => $item['tahun_ke'],
          'besaran' => $item['besaran'],
          'status' => 'A'
        ]);
      }

      if ($request->hasFile('file_pendukung')) {
        foreach ($request->file('file_pendukung') as $file) {
          $fileName = $file->getClientOriginalName();
          $filePath = $file->storeAs('file_pendukung', $fileName, 'public');
          TransaksiFile::create([
            'transaksi_id' => $transaksi->transaksi_id,
            'file_name' => $fileName,
            'path' => $filePath,
          ]);
        }
      }
      DB::commit();

      // return $request->all();
      Alert::success('Success', 'Data Berhasil ditambahkan');
      return redirect()->route('sewa.index');
    } catch (\Throwable $th) {
      DB::rollBack();
      return $th;
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    try {
      $item = Transaksi::with('Jenis', 'Pembayaran', 'File', 'Kenaikan')->find($id);
      if (!$item) {
        Alert::warning('Warning', 'Transaksi Sewa Tidak Ditemukan');
        return redirect()->back();
      }

      // Count related data
      $pembayaranCount = $item->Pembayaran->count();
      $kenaikanCount = $item->Kenaikan->count();

      return view('pages.Sewa.detail', compact('item', 'pembayaranCount', 'kenaikanCount'));
    } catch (\Throwable $th) {
      return 404;
    }
  }

  public function PrintSewa(string $id)
  {
    try {
      $item = Transaksi::with('Jenis', 'Pembayaran', 'Kenaikan')->find($id);
      if (!$item) {
        Alert::warning('Warning', 'Transaksi Sewa Tidak Ditemukan');
        return redirect()->back();
      }

      return view('pages.Sewa.print', compact('item',));
    } catch (\Throwable $th) {
      return 404;
    }
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    try {
      $item = Transaksi::with('Pembayaran', 'File', 'Jenis')->where('transaksi_id', $id)->first();
      $jenis = JenisSewa::get();
      if (!$item) {
        Alert::warning('Warning', 'Transaksi Sewa Tidak Ditemukan');
        return redirect()->back();
      }
      return view('pages.Sewa.edit', compact('item', 'jenis'));
    } catch (\Throwable $th) {
      Alert::warning('Warning', 'Internal Server Error');
      return redirect()->back();
    }
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    try {
      $datas = Transaksi::where('transaksi_id', $id)->first();
      if (!$datas) {
        Alert::warning('Warning', 'Transaksi Sewa Tidak Ditemukan');
        return redirect()->back();
      }
      //Begin Transaction
      DB::beginTransaction();
      $datas['lokasi'] = $request->lokasi;
      $datas['nomor_perjanjian'] = $request->nomor_perjanjian;
      $datas['tanggal_perjanjian'] = $request->tanggal_perjanjian;
      $datas['nomor_tanggal_perjanjian'] = $request->nomor_perjanjian && $request->tanggal_perjanjian;
      $datas['nomor_kode_barang'] = $request->nomor_kode_barang;
      $datas['nomor_register'] = $request->nomor_register;
      $datas['sertipikat'] = $request->sertipikat;
      $datas['jumlah_bidang_sewa_bagian'] = $request->jumlah_bidang_sewa_bagian;
      $datas['luas_total_sertipikat'] = $request->luas_total_sertipikat;
      $datas['luas_yang_disewa'] = $request->luas_yang_disewa;
      $datas['nama_pengguna'] = $request->nama_pengguna;
      $datas['nomor_telepon'] = $request->nomor_telepon;
      $datas['email'] = $request->email;
      $datas['NIK'] = $request->NIK;
      $datas['umur'] = $request->umur;
      $datas['pekerjaan'] = $request->pekerjaan;
      $datas['alamat'] = $request->alamat;
      $datas['peruntukan'] = $request->peruntukan;
      $datas['jangka_waktu_kerjasama'] = $request->jangka_waktu_kerjasama;
      $datas['tahun_peninjauan_berikutnya'] = $request->tahun_peninjauan_berikutnya;
      $datas['jumlah_bidang_sewa_keseluruhan'] = $request->jumlah_bidang_sewa_keseluruhan;
      $datas['sistem_pembayaran'] = $request->sistem_pembayaran;
      $datas['sistem_pembayaran_ket'] = $request->sistem_pembayaran_ket;
      $datas['jangka_waktu_mulai'] = $request->jangka_waktu_mulai;
      $datas['jangka_waktu_selesai'] = $request->jangka_waktu_selesai;
      $datas['besar_sewa'] = $request->besar_sewa;
      $datas['besar_sewa_per'] = $request->besar_sewa_per;
      $datas['kontribusi_awal'] = $request->kontribusi_awal;
      $datas['kabupaten'] = $request->kabupaten;
      $datas['keterangan'] = $request->keterangan;
      $datas['jenis_id'] = $request->jenis_id;
      $datas->update();
      DB::commit();

      Alert::success('Success', 'Data Sewa Berhasil Diupdate');
      return redirect()->route('sewa.show', $datas->transaksi_id);
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
      $tr = Transaksi::find($id);
      if (!$tr) {
        Alert::warning('Warning', 'Internal Server Error');
        return redirect()->back();
      }

      Pembayaran::where('transaksi_id', $tr->transaksi_id)->delete();
      $files = $tr->File;
      foreach ($files as $file) {
        if (Storage::disk('public')->exists($file->path)) {
          Storage::disk('public')->delete($file->path);
        }
        $file->delete();
      }
      $tr->Kenaikan()->delete();

      $tr->delete();
      DB::commit();

      Alert::success('Success', 'Data Sewa Berhasil Dihapus');
      return redirect()->route('dashboard');
    } catch (\Throwable $th) {
      DB::rollBack();
      Alert::warning('Warning', 'Internal Server Error');
      return redirect()->back();
    }
  }
}
