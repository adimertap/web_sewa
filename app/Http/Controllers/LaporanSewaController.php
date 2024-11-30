<?php

namespace App\Http\Controllers;

use App\Models\JenisSewa;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FilteredDataExport;
use Alert;

class LaporanSewaController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    try {
      $jenis = JenisSewa::get();

      // Fetch filters
      $jenisId = $request->input('jenis');
      $kabupaten = $request->input('kabupaten');
      $sistemPembayaran = $request->input('sistem_pembayaran');
      $lokasi = $request->input('lokasi');
      $jangkaWaktu = $request->input('jangka_waktu');

      // Query with filters
      $query = Transaksi::with('Jenis')->orderBy('transaksi_id', 'DESC');

      if ($jenisId) {
        $query->where('jenis_id', $jenisId);
      }
      if ($kabupaten) {
        $query->where('kabupaten', $kabupaten);
      }
      if ($sistemPembayaran) {
        $query->where('sistem_pembayaran', $sistemPembayaran);
      }
      if ($lokasi) {
        $query->where('lokasi', $lokasi);
      }
      if ($jangkaWaktu) {
        $query->where('jangka_waktu_kerjasama', $jangkaWaktu);
      }

      $datas = $query->paginate(10); // Use pagination, showing 10 results per page.

      // Populate dropdown options
      $kab = Transaksi::select('kabupaten')->distinct()->orderBy('kabupaten', 'ASC')->pluck('kabupaten')->toArray();
      $sbayar = Transaksi::select('sistem_pembayaran')->distinct()->orderBy('sistem_pembayaran', 'ASC')->pluck('sistem_pembayaran')->toArray();
      $sertif = Transaksi::select('sertipikat')->distinct()->orderBy('sertipikat', 'ASC')->pluck('sertipikat')->toArray();
      $lokasi = Transaksi::select('lokasi')->distinct()->orderBy('lokasi', 'ASC')->pluck('lokasi')->toArray();
      $waktuSewa = Transaksi::select('jangka_waktu_kerjasama')->distinct()->orderBy('jangka_waktu_kerjasama', 'ASC')->pluck('jangka_waktu_kerjasama')->toArray();

      return view('pages.SewaLaporan.index', compact('jenis', 'datas', 'kab', 'sbayar', 'sertif', 'lokasi', 'waktuSewa'));
    } catch (\Throwable $th) {
      return $th;
    }
  }

  // public function Excel(Request $request)
  // {
  //   $tahun = $request->input('tahun');

  //   $transaksi = Transaksi::with(['Pembayaran', 'Kenaikan'])->when($tahun, function ($query) use ($tahun) {
  //     $query->whereHas('Pembayaran', function ($query) use ($tahun) {
  //       $query->where('pembayaran_tahun', $tahun);
  //     });
  //   })->get();

  //   $exportData = $transaksi->map(function ($item, $index) {
  //     $row = [
  //       'no' => $index + 1,
  //       'lokasi' => $item->lokasi,
  //       'nomor_tanggal_perjanjian' => $item->nomor_tanggal_perjanjian,
  //       'nomor_kode_barang' => $item->nomor_kode_barang,
  //       'nomor_register' => $item->nomor_register,
  //       'sertipikat' => $item->sertipikat,
  //       'jumlah_bidang_sewa_sebagian' => $item->jumlah_bidang_sewa_bagian,
  //       'luas_total_sertipikat' => $item->luas_total_sertipikat,
  //       'luas_yang_disewa' => $item->luas_yang_disewa,
  //       'nama_pengguna' => $item->nama_pengguna,
  //       'nomor_telepon' => $item->nomor_telepon,
  //       'peruntukan' => $item->peruntukan,
  //       'tahun_peninjauan_berikutnya' => $item->tahun_peninjauan_berikutnya,
  //       'jumlah_bidang_sewa_keseluruhan' => $item->jumlah_bidang_sewa_keseluruhan,
  //       'jatuh_tempo_pembangunan' => $item->jatuh_tempo_pembangunan,
  //       'jatuh_tempo_pembayaran' => $item->jatuh_tempo_pembayaran,
  //       'sistem_pembayaran' => $item->sistem_pembayaran,
  //       'jangka_waktu_mulai' => $item->jangka_waktu_mulai,
  //       'jangka_waktu_berakhir' => $item->jangka_waktu_selesai,
  //       'besar_sewa' => $item->besar_sewa,
  //       'kontribusi_awal' => $item->kontribusi_awal,
  //       'keterangan' => $item->keterangan,
  //       'kabupaten' => $item->kabupaten,
  //     ];

  //     foreach ($item->Kenaikan as $index => $kenaikan) {
  //       $row["kenaikan_tahun_ke_" . ($index + 2)] = $kenaikan->tahun;
  //     }

  //     foreach ($item->Pembayaran as $pembayaran) {
  //       $row["pembayaran_tahun_" . $pembayaran->pembayaran_tahun] = $pembayaran->nominal;
  //     }

  //     return $row;
  //   });

  //   return Excel::download(new FilteredDataExport($exportData), 'laporan_sewa.xlsx');
  // }
  public function Excel(Request $request)
  {
    $tahun = $request->input('tahun');
    $jenis = $request->input('jenis');
    $kabupaten = $request->input('kabupaten');
    $sistemPembayaran = $request->input('sistem_pembayaran');
    $lokasi = $request->input('lokasi');
    $jangkaWaktu = $request->input('jangka_waktu');

    $tr = Transaksi::with(['Pembayaran', 'Kenaikan', 'Jenis'])
      ->when($tahun, function ($query) use ($tahun) {
        $query->whereHas('Pembayaran', function ($query) use ($tahun) {
          $query->where('pembayaran_tahun', $tahun);
        });
      })
      ->when($jenis, function ($query) use ($jenis) {
        $query->where('jenis_id', $jenis);
      })
      ->when($kabupaten, function ($query) use ($kabupaten) {
        $query->where('kabupaten', $kabupaten);
      })
      ->when($sistemPembayaran, function ($query) use ($sistemPembayaran) {
        $query->where('sistem_pembayaran', $sistemPembayaran);
      })
      ->when($lokasi, function ($query) use ($lokasi) {
        $query->where('lokasi', $lokasi);
      })
      ->when($jangkaWaktu, function ($query) use ($jangkaWaktu) {
        $query->where('jangka_waktu_kerjasama', $jangkaWaktu);
      })
      ->get();

    if ($tr->isEmpty()) {
      // Display warning message and redirect back
      Alert::warning('Warning', 'Data tidak ditemukan');
      return redirect()->back();
    }



    // Determine min and max years for Pembayaran
    $minPembayaranYear = $tr->flatMap(function ($item) {
      return $item->Pembayaran->pluck('pembayaran_tahun');
    })->min();

    $maxPembayaranYear = $tr->flatMap(function ($item) {
      return $item->Pembayaran->pluck('pembayaran_tahun');
    })->max();

    // Determine min and max years for Kenaikan
    $minKenaikanYear = $tr->flatMap(function ($item) {
      return $item->Kenaikan->pluck('tahun_ke');
    })->min();

    $maxKenaikanYear = $tr->flatMap(function ($item) {
      return $item->Kenaikan->pluck('tahun_ke');
    })->max();

    $exportData = $tr->map(function ($item, $index) use ($minPembayaranYear, $maxPembayaranYear, $minKenaikanYear, $maxKenaikanYear) {
      $row = [
        'no' => $index + 1,
        'jenis' => $item->Jenis->jenis_nama,
        'lokasi' => $item->lokasi,
        'nomor_tanggal_perjanjian' => $item->nomor_tanggal_perjanjian,
        'nomor_kode_barang' => $item->nomor_kode_barang,
        'nomor_register' => $item->nomor_register,
        'sertipikat' => $item->sertipikat,
        'jumlah_bidang_sewa_sebagian' => $item->jumlah_bidang_sewa_bagian,
        'luas_total_sertipikat' => $item->luas_total_sertipikat,
        'luas_yang_disewa' => $item->luas_yang_disewa,
        'nama_pengguna' => $item->nama_pengguna,
        'nomor_telepon' => $item->nomor_telepon,
        'peruntukan' => $item->peruntukan,
        'tahun_peninjauan_berikutnya' => $item->tahun_peninjauan_berikutnya,
        'jumlah_bidang_sewa_keseluruhan' => $item->jumlah_bidang_sewa_keseluruhan,
        'jatuh_tempo_pembangunan' => $item->jatuh_tempo_pembangunan,
        'jatuh_tempo_pembayaran' => $item->jatuh_tempo_pembayaran,
        'sistem_pembayaran' => $item->sistem_pembayaran,
        'jangka_waktu_mulai' => $item->jangka_waktu_mulai,
        'jangka_waktu_berakhir' => $item->jangka_waktu_selesai,
        'besar_sewa' => $item->besar_sewa,
        'kontribusi_awal' => $item->kontribusi_awal,
        'keterangan' => $item->keterangan,
        'kabupaten' => $item->kabupaten,
      ];

      // Add Kenaikan data dynamically
      for ($year = $minKenaikanYear; $year <= $maxKenaikanYear; $year++) {
        $kenaikan = $item->Kenaikan->firstWhere('tahun_ke', $year);
        $row["kenaikan tahun ke $year"] = $kenaikan ? 'Rp ' . number_format($kenaikan->besaran, 0, ',', '.') : null;
      }

      // Add Pembayaran data dynamically
      for ($year = $minPembayaranYear; $year <= $maxPembayaranYear; $year++) {
        $pembayaran = $item->Pembayaran->firstWhere('pembayaran_tahun', $year);
        $row["pembayaran tahun $year"] = $pembayaran ? 'Rp ' . number_format($pembayaran->nominal, 0, ',', '.') : null;
      }

      return $row;
    });

    return Excel::download(new FilteredDataExport($exportData, $minPembayaranYear, $maxPembayaranYear, $minKenaikanYear, $maxKenaikanYear), 'laporan_sewa.xlsx');
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
    //
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
