<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Alert;
use Carbon\Carbon;
use App\Models\JenisSewa;
use App\Models\Kenaikan;
use App\Models\MasterSistemBayar;
use App\Models\Pembayaran;
use App\Models\Transaksi;
use App\Models\TransaksiFile;
use App\Models\TransaksiNomor;
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

    $sistem = MasterSistemBayar::get();

    $currentDate = Carbon::now(); // Gets the current date and time
    $dateNow = Carbon::now()->toDateString(); // Formats it to 'YYYY-MM-DD'
    if (!$jenis) {
      Alert::warning('Warning', 'Internal Server Error');
      return redirect()->back();
    }

    return view('pages.Sewa.tambah', compact('jenis', 'dateNow', 'sistem'));
  }

  public function Selesai($id)
  {
    try {
      $tr = Transaksi::where('transaksi_id', $id)->first();
      if (!$tr) {
        Alert::warning('Warning', 'Data tidak ditemukan');
        return redirect()->back();
      }
      DB::beginTransaction();
      $tr->status = 'N';
      $tr->update();
      DB::commit();

      Alert::success('Success', 'Data Sewa Selesai');
      return redirect()->back();
    } catch (\Throwable $th) {
      DB::rollBack();
      return $th;
    }
  }

  public function TambahNomor(Request $request, $id)
  {
    try {
      $check = Transaksi::where('transaksi_id', $id)->first();
      if (!$check) {
        Alert::warning('Warning', 'Data tidak ditemukan');
        return redirect()->back();
      }

      DB::beginTransaction();
      $data = new TransaksiNomor();
      $data->transaksi_id = $id;
      $data->nomor_perjanjian = $request->nomor_perjanjian;
      $data->tanggal_perjanjian = $request->tanggal_perjanjian;
      $data->save();

      DB::commit();
      Alert::success('Success', 'Data Nomor Perjanjian Berhasil ditambahkan');
      return redirect()->back();
    } catch (\Throwable $th) {
      DB::rollBack();
      return $th;
    }
  }

  public function DeleteNomor($id)
  {
    try {
      DB::beginTransaction();
      $tr = TransaksiNomor::find($id);
      if (!$tr) {
        Alert::warning('Warning', 'Internal Server Error');
        return redirect()->back();
      }
      $tr->delete();
      DB::commit();

      Alert::success('Success', 'Data Nomor Perjanjian Berhasil Dihapus');
      return redirect()->back();
    } catch (\Throwable $th) {
      DB::rollBack();
      Alert::warning('Warning', 'Internal Server Error');
      return redirect()->back();
    }
  }
  public function UpdateNomor(Request $request)
  {
    try {
      $tr = TransaksiNomor::find($request->transaksi_nomor_id);
      if (!$tr) {
        Alert::warning('Warning', 'Internal Server Error');
        return redirect()->back();
      }

      DB::beginTransaction();
      $tr->nomor_perjanjian = $request->nomor_perjanjian_m;
      $tr->tanggal_perjanjian = $request->tanggal_perjanjian_m;
      $tr->update();
      DB::commit();

      Alert::success('Success', 'Data Kenaikan Berhasil Diupdate');
      return redirect()->back();
    } catch (\Throwable $th) {
      DB::rollBack();
      return $th;
    }
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
      $besaran = preg_replace('/\./', '', $request->besaran); // Remove the period separator
      $besaran = floatval($besaran); // Convert to float

      DB::beginTransaction();
      $data = new Kenaikan();
      $data->transaksi_id = $id;
      $data->tahun_ke = $request->tahun_ke;
      $data->besaran = $besaran;
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

      $nominal = preg_replace('/\./', '', $request->nominal); // Remove the period separator
      $nominal = floatval($nominal); // Convert to float

      DB::beginTransaction();
      $data = new Pembayaran();
      $data->transaksi_id = $id;
      $data->pembayaran_tahun = $request->pembayaran_tahun;
      $data->pembayaran_tanggal = $request->pembayaran_tanggal;
      $data->nominal = $nominal;
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

      $besaran = preg_replace('/\./', '', $request->besaran); // Remove the period separator
      $besaran = floatval($besaran); // Convert to float

      DB::beginTransaction();
      $tr->tahun_ke = $request->tahun_ke;
      $tr->besaran = $besaran;
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

      $nominal = preg_replace('/\./', '', $request->nominal); // Remove the period separator
      $nominal = floatval($nominal); // Convert to float

      DB::beginTransaction();
      $tr->pembayaran_tahun = $request->pembayaran_tahun;
      $tr->pembayaran_tanggal = $request->pembayaran_tanggal;
      $tr->nominal = $nominal;
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
      $jatuhTempoPembangunan = $request->input('jatuh_tempo_pembangunan');
      $jenis = JenisSewa::where('jenis_nama', $request->jenis_id)->first();
      $findSame = Transaksi::where('nomor_perjanjian', $request->nomor_perjanjian)
        ->where('jenis_id', $jenis->jenis_id)
        ->first();
      if ($findSame) {
        Alert::warning('Warning', 'Transaksi Jenis ' . $jenis->jenis_nama . ', dengan nomor ' . $findSame->nomor_perjanjian . ' sudah ada.');
        return redirect()->back();
      }

      $besar_sewa = preg_replace('/\./', '', $request->besar_sewa); // Remove the period separator
      $besar_sewa = floatval($besar_sewa); // Convert to float
      $kontribusi_awal = preg_replace('/\./', '', $request->kontribusi_awal); // Remove the period separator
      $kontribusi_awal = floatval($kontribusi_awal); // Convert to float

      DB::beginTransaction();
      $transaksiData = [
        'lokasi' => $request->lokasi,
        'nomor_perjanjian' => $request->nomor_perjanjian,
        'tanggal_perjanjian' => $request->tanggal_perjanjian,
        'nomor_tanggal_perjanjian' => $request->nomor_perjanjian && $request->tanggal_perjanjian,
        'nomor_kode_barang' => $request->nomor_kode_barang,
        'nomor_register' => $request->nomor_register,
        'sertipikat' => $request->sertipikat,
        'jumlah_bidang_sewa_bagian' => $request->jumlah_bidang_sewa_bagian,
        'luas_total_sertipikat' => $request->luas_total_sertipikat,
        'luas_yang_disewa' => $request->luas_yang_disewa,
        'nama_pengguna' => $request->nama_pengguna,
        'nomor_telepon' => $request->nomor_telepon,
        'email' => $request->email,
        'NIK' => $request->NIK,
        'umur' => $request->umur,
        'pekerjaan' => $request->pekerjaan,
        'alamat' => $request->alamat,
        'peruntukan' => $request->peruntukan,
        'jangka_waktu_kerjasama' => $request->jangka_waktu_kerjasama,
        'tahun_peninjauan_berikutnya' => $request->tahun_peninjauan_berikutnya,
        'jumlah_bidang_sewa_keseluruhan' => $request->jumlah_bidang_sewa_keseluruhan,
        'sistem_id' => $request->sistem_id,
        'sistem_pembayaran_ket' => $request->sistem_pembayaran_ket,
        'jangka_waktu_mulai' => $request->jangka_waktu_mulai,
        'jangka_waktu_selesai' => $request->jangka_waktu_selesai,
        'besar_sewa' => $besar_sewa,
        'besar_sewa_per' => $request->besar_sewa_per,
        'kontribusi_awal' => $kontribusi_awal,
        'kabupaten' => $request->kabupaten,
        'status' => "A",
        'keterangan' => $request->keterangan,
        'jenis_id' => $jenis->jenis_id,
        'jatuh_tempo_pembangunan' => $jatuhTempoPembangunan, // Store the radio button value
        'jatuh_tempo_pembayaran' => $request->jatuh_tempo_pembayaran,
        'kecamatan' => $request->kecamatan,
        'desa' => $request->desa
      ];

      $transaksi = Transaksi::create($transaksiData);
      foreach ($request->input('group-a') as $item) {
        $nominal = preg_replace('/\./', '', $item['nominal']); // Remove the period separator
        $nominal = floatval($nominal); // Convert to float

        Pembayaran::create([
          'transaksi_id' => $transaksi->transaksi_id,
          'pembayaran_tahun' => $item['pembayaran_tahun'],
          'nominal' => $nominal,
          'pembayaran_tanggal' => $item['pembayaran_tanggal'],
          'keterangan' => $item['ket'],
          'status' => 'A'
        ]);
      }

      foreach ($request->input('nomor-a') as $item) {
        TransaksiNomor::create([
          'transaksi_id' => $transaksi->transaksi_id,
          'nomor_perjanjian' => $item['nomor_perjanjian'],
          'tanggal_perjanjian' => $item['tanggal_perjanjian']
        ]);
      }


      foreach ($request->input('kenaikan-a') as $item) {
        $besaran = preg_replace('/\./', '', $item['besaran']); // Remove the period separator
        $besaran = floatval($besaran); // Convert to float

        Kenaikan::create([
          'transaksi_id' => $transaksi->transaksi_id,
          'tahun_ke' => $item['tahun_ke'],
          'besaran' => $besaran,
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
      return redirect()->route('dashboard');
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
      $item = Transaksi::with('Jenis', 'Pembayaran', 'File', 'Kenaikan', 'Nomor', 'SistemBayar')->find($id);
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
      $item = Transaksi::with('Jenis', 'Pembayaran', 'Kenaikan', 'SistemBayar', 'Nomor')->find($id);
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
      $sistem = MasterSistemBayar::get();

      if (!$item) {
        Alert::warning('Warning', 'Transaksi Sewa Tidak Ditemukan');
        return redirect()->back();
      }
      return view('pages.Sewa.edit', compact('item', 'jenis', 'sistem'));
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
      $besar_sewa = preg_replace('/\./', '', $request->besar_sewa); // Remove the period separator
      $besar_sewa = floatval($besar_sewa); // Convert to float
      $kontribusi_awal = preg_replace('/\./', '', $request->kontribusi_awal); // Remove the period separator
      $kontribusi_awal = floatval($kontribusi_awal); // Convert to float
      $jatuhTempoPembangunan = $request->input('jatuh_tempo_pembangunan');

      DB::beginTransaction();
      $datas['lokasi'] = $request->lokasi;
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
      $datas['jatuh_tempo_pembangunan'] = $jatuhTempoPembangunan;
      $datas['peruntukan'] = $request->peruntukan;
      $datas['jangka_waktu_kerjasama'] = $request->jangka_waktu_kerjasama;
      $datas['tahun_peninjauan_berikutnya'] = $request->tahun_peninjauan_berikutnya;
      $datas['jumlah_bidang_sewa_keseluruhan'] = $request->jumlah_bidang_sewa_keseluruhan;
      $datas['sistem_pembayaran'] = $request->sistem_id;
      $datas['sistem_pembayaran_ket'] = $request->sistem_pembayaran_ket;
      $datas['jangka_waktu_mulai'] = $request->jangka_waktu_mulai;
      $datas['jangka_waktu_selesai'] = $request->jangka_waktu_selesai;
      $datas['besar_sewa'] = $besar_sewa;
      $datas['besar_sewa_per'] = $request->besar_sewa_per;
      $datas['kontribusi_awal'] = $kontribusi_awal;
      $datas['kabupaten'] = $request->kabupaten;
      $datas['kecamatan'] = $request->kecamatan;
      $datas['desa'] = $request->desa;
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
