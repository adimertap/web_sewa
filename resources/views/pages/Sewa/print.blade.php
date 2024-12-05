{{-- @extends('layouts/layoutMaster') --}}

@extends('layouts.blankLayout')

@section('title', 'Cetak Perekaman')

@section('vendor-style')
{{--
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss')}}" /> --}}
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/animate-css/animate.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}" />
<link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
@endsection

@section('page-style')
<link rel="stylesheet" href="{{asset('assets/vendor/scss/pages/app-invoice.css')}}" />
@endsection
<!-- Vendor Scripts -->
@section('vendor-script')
<script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
<script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/extended-ui-sweetalert2.js')}}"></script>
@endsection

@section('content')
@include('sweetalert::alert')


<div class="p-2">
  <h4>Data Penyewaan</h4>
  <hr>
  <div class="row mt-4">
    <div class="row mb-1">
      <div class="col-4">
        <p class="mb-1 fw-medium">Jenis</p>
      </div>
      <div class="col-8">
        <p class="mb-1">: {{ $item->Jenis->jenis_nama ?? '-' }}</p>
      </div>
    </div>
    <div class="row mb-1">
      <div class="col-4">
        <p class="mb-1 fw-medium">Kabupaten/Kota</p>
      </div>
      <div class="col-8">
        <p class="mb-1">: {{ $item->kabupaten ?? '-' }}</p>
      </div>
    </div>
    <div class="row mb-1">
      <div class="col-4">
        <p class="mb-1 fw-medium">Tanggal</p>
      </div>
      <div class="col-8">
        <p class="mb-1">: {{ isset($item->Nomor[0]) ? $item->Nomor[0]->tanggal_perjanjian : '-' }}</p>
      </div>
    </div>
    <div class="row mb-1">
      <div class="col-4">
        <p class="mb-1 fw-medium">Jangka Waktu Kerjasama</p>
      </div>
      <div class="col-8">
        <p class="mb-1">: {{ $item->jangka_waktu_kerjasama ?? '-' }}</p>
      </div>
    </div>
  </div>
  <hr>
  <div class="row mt-4">
    <div class="row mb-1">
      <div class="col-4">
        <p class="mb-1 fw-medium">NIK</p>
      </div>
      <div class="col-8">
        <p class="mb-1">: {{ $item->NIK ?? '-' }}</p>
      </div>
    </div>
    <div class="row mb-1">
      <div class="col-4">
        <p class="mb-1 fw-medium">Nama</p>
      </div>
      <div class="col-8">
        <p class="mb-1 fw-medium">: {{ $item->nama_pengguna ?? '-' }} </p>
      </div>
    </div>
    <div class="row mb-1">
      <div class="col-4">
        <p class="mb-1 fw-medium">Telphone</p>
      </div>
      <div class="col-8">
        <p class="mb-1">: {{ $item->nomor_telepon ?? '-' }}</p>
      </div>
    </div>
    <div class="row mb-1">
      <div class="col-4">
        <p class="mb-1">Email</p>
      </div>
      <div class="col-8">
        <p class="mb-1">: {{ $item->email ?? '-' }}</p>
      </div>
    </div>
    <div class="row mb-1">
      <div class="col-4">
        <p class="mb-1 fw-medium">Umur</p>
      </div>
      <div class="col-8">
        <p class="mb-1">: {{ $item->umur ?? '-' }} Tahun</p>
      </div>
    </div>
    <div class="row mb-1">
      <div class="col-4">
        <p class="mb-1 fw-medium">Pekerjaan</p>
      </div>
      <div class="col-8">
        <p class="mb-1">: {{ $item->pekerjaan ?? '-' }}</p>
      </div>
    </div>
    <div class="row mb-1">
      <div class="col-4">
        <p class="mb-1 fw-medium">Alamat</p>
      </div>
      <div class="col-8">
        <p class="mb-1">: {{ $item->alamat ?? '-' }}</p>
      </div>
    </div>
    <div class="row mb-1">
      <div class="col-4">
        <p class="mb-1 fw-medium">Peruntukan</p>
      </div>
      <div class="col-8">
        <p class="mb-1 fw-medium">: {{ $item->peruntukan ?? '-' }}</p>
      </div>
    </div>

    <hr>
    <!-- Pembayaran dan Jatuh Tempo -->
    <div class="row mb-1 mt-1">
      <div class="col-4">
        <p class="mb-1 fw-medium">Sistem Pembayaran</p>
      </div>
      <div class="col-8">
        <p class="mb-1">: {{ $item->SistemBayar->sistem_pembayaran ?? '-' }}</p>
      </div>
    </div>
    <div class="row mb-1">
      <div class="col-4">
        <p class="mb-1 fw-medium">Jangka Waktu Mulai</p>
      </div>
      <div class="col-8">
        <p class="mb-1">: {{ $item->jangka_waktu_mulai ?? '-' }}</p>
      </div>
    </div>
    <div class="row mb-1">
      <div class="col-4">
        <p class="mb-1 fw-medium">Jangka Waktu Selesai</p>
      </div>
      <div class="col-8">
        <p class="mb-1">: {{ $item->jangka_waktu_selesai ?? '-' }}</p>
      </div>
    </div>
    <div class="row mb-1">
      <div class="col-4">
        <p class="mb-1 fw-medium">Jatuh Tempo Pembayaran</p>
      </div>
      <div class="col-8">
        <p class="mb-1">: {{ $item->jatuh_tempo_pembangunan ?? '-' }}</p>
      </div>
    </div>
    <div class="row mb-1">
      <div class="col-4">
        <p class="mb-1 fw-medium">Jatuh Tempo Pembayaran</p>
      </div>
      <div class="col-8">
        <p class="mb-1">: {{ $item->jatuh_tempo_pembayaran ?? '-' }}</p>
      </div>
    </div>
    <hr>
    <div class="row mb-1">
      <div class="col-4">
        <p class="mb-1 fw-medium">Besaran Sewa</p>
      </div>
      <div class="col-8">
        <p class="mb-1">: Rp {{ number_format($item->besar_sewa, 0, ',', '.') }} </p>
      </div>
    </div>
    <div class="row mb-1">
      <div class="col-4">
        <p class="mb-1 fw-medium ">Ket. Besaran Sewa</p>
      </div>
      <div class="col-8">
        <p class="mb-1 ">: {{ $item->besar_sewa_per ?? '-' }}</p>
      </div>
    </div>
    <div class="row mb-1">
      <div class="col-4">
        <p class="mb-1 fw-medium ">Kontribusi Awal</p>
      </div>
      <div class="col-8">
        <p class="mb-1 ">: Rp {{ number_format($item->kontribusi_awal, 0, ',', '.') }}</p>
      </div>
    </div>
  </div>

  <div class="row mb-1 mt-2">
    <div class="col-4">
      <p class="mb-1 fw-medium">Kode Barang</p>
    </div>
    <div class="col-8">
      <p class="mb-1">: {{ $item->nomor_kode_barang ?? '-' }}</p>
    </div>
  </div>
  <div class="row mb-1">
    <div class="col-4">
      <p class="mb-1 fw-medium">Sertipikat</p>
    </div>
    <div class="col-8">
      <p class="mb-1">: {{ $item->sertipikat ?? '-' }}</p>
    </div>
  </div>
  <div class="row mb-1">
    <div class="col-4">
      <p class="mb-1 fw-medium">Bidang Sewa Sebagian</p>
    </div>
    <div class="col-8">
      <p class="mb-1">: {{ $item->jumlah_bidang_sewa_bagian ?? '-' }}</p>
    </div>
  </div>
  <div class="row mb-1">
    <div class="col-4">
      <p class="mb-1 fw-medium">Bidang Sewa Seluruh</p>
    </div>
    <div class="col-8">
      <p class="mb-1">: {{ $item->jumlah_bidang_sewa_keseluruhan ?? '-' }}</p>
    </div>
  </div>
  <div class="row mb-1">
    <div class="col-4">
      <p class="mb-1 fw-medium">Lokasi</p>
    </div>
    <div class="col-8">
      <p class="mb-1">: {{ $item->lokasi ?? '-' }}</p>
    </div>
  </div>


  <div class="row mb-1">
    <div class="col-4">
      <p class="mb-1 fw-medium">Nomor Register</p>
    </div>
    <div class="col-8">
      <p class="mb-1">: {{ $item->nomor_register ?? '-' }}</p>
    </div>
  </div>
  <div class="row mb-1">
    <div class="col-4">
      <p class="mb-1 fw-medium">Luas Total Sertipikat</p>
    </div>
    <div class="col-8">
      <p class="mb-1">: {{ $item->luas_total_sertipikat ?? '-' }}</p>
    </div>
  </div>
  <div class="row mb-1">
    <div class="col-4">
      <p class="mb-1 fw-medium">Luas yang di Sewa</p>
    </div>
    <div class="col-8">
      <p class="mb-1">: {{ $item->luas_yang_disewa ?? '-' }}</p>
    </div>
  </div>
  <div class="row mb-1">
    <div class="col-4">
      <p class="mb-1 fw-medium">Tahun Peninjauan Berikutnya</p>
    </div>
    <div class="col-8">
      <p class="mb-1">: {{ $item->tahun_peninjauan_berikutnya ?? '-' }}</p>
    </div>
  </div>
  <div class="row mb-1">
    <div class="col-4">
      <p class="mb-1 fw-medium">Jangka Waktu Kerjasama</p>
    </div>
    <div class="col-8">
      <p class="mb-1 fw-medium">: {{ $item->jangka_waktu_kerjasama ?? '-' }}</p>
    </div>
  </div>
  <div class="row mb-1">
    <div class="col-4">
      <p class="mb-1 fw-medium">Keterangan</p>
    </div>
    <div class="col-8">
      <p class="mb-1 fw-medium">: {{ $item->keterangan ?? '-' }}</p>
    </div>
  </div>
  <hr>
  <!-- Detail Pembayaran -->
  <h6 class="p-2 mt-2">Nomor Perjanjian:</h6>
  <div class="table-responsive">
    <table class="table table-bordered small m-0">
      <thead class="border-top">
        <tr>
          <th class="text-center">No.</th>
          <th class="text-center">Nomor</th>
          <th class="text-center">Tanggal</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($item->Nomor as $nomor)
        <tr role="row" class="odd">
          <td class="text-center">{{ $loop->iteration }}.</td>
          <td class="text-center" data-label="Tahun">{{ $nomor->nomor_perjanjian }}</td>
          <td class="text-center" data-label="Tanggal">{{ $nomor->tanggal_perjanjian }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <!-- Detail Pembayaran -->
  <h6 class="p-2 mt-3">Detail Pembayaran:</h6>
  <div class="table-responsive">
    <table class="table table-bordered small m-0">
      <thead class="border-top">
        <tr>
          <th class="text-center">No.</th>
          <th class="text-center">Tahun</th>
          <th class="text-center">Tanggal</th>
          <th class="text-center">Keterangan</th>
          <th class="text-center">Nominal</th>
        </tr>
      </thead>
      <tbody>
        @php
        $totalNominal = 0; // Initialize a variable to accumulate the total
        @endphp
        @foreach ($item->Pembayaran as $bayar)
        <tr role="row" class="odd">
          <td class="text-center">{{ $loop->iteration }}.</td>
          <td class="text-center" data-label="Tahun">{{ $bayar->pembayaran_tahun }}</td>
          <td class="text-center" data-label="Tanggal">{{ $bayar->pembayaran_tanggal }}</td>
          <td class="text-center" data-label="Keterangan">{{ $bayar->keterangan ?? '' }}</td>
          <td class="text-center" data-label="Nominal">Rp {{ number_format($bayar->nominal, 0, ',', '.') }}</td>
        </tr>
        @php
        $totalNominal += $bayar->nominal; // Add the current nominal to the total
        @endphp
        @endforeach
        <tr>
          <td colspan="4" class="text-center">Total</td>
          <td class="text-center">Rp {{ number_format($totalNominal, 0, ',', '.') }}</td>
        </tr>
      </tbody>
    </table>
  </div>


  {{-- KENAIKAN --}}
  <h6 class="p-2 mt-3">Detail Kenaikan:</h6>
  <div class="table-responsive">
    <table class="table table-bordered small m-0">
      <thead class="border-top">
        <tr>
          <th class="text-center">No.</th>
          <th class="text-center">Tahun Ke-</th>
          <th class="text-center">Nominal</th>
        </tr>
      </thead>
      <tbody>
        @php
        $totalNominal = 0; // Initialize a variable to accumulate the total
        @endphp
        @foreach ($item->Kenaikan as $kenaikan)
        <tr role="row" class="odd">
          <td class="text-center">{{ $loop->iteration }}.</td>
          <td class="text-center" data-label="Tahun">Tahun Ke- {{ $kenaikan->tahun_ke }}</td>
          <td class="text-center" data-label="Nominal">Rp {{ number_format($kenaikan->besaran, 0, ',', '.') }}
          </td>
        </tr>
        @php
        $totalNominal += $kenaikan->besaran; // Add the current nominal to the total
        @endphp
        @endforeach
        <tr>
          <td colspan="2" class="text-center">Total</td>
          <td class="text-center">Rp {{ number_format($totalNominal, 0, ',', '.') }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<script src="{{asset('assets/vendor/libs/jquery/jquery.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/dropzone@5.9.3/dist/dropzone.min.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    window.print();
  });
</script>
@endsection