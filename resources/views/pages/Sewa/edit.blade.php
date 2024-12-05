@php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
@endphp
@php
$configData = Helper::appClasses();
@endphp
@extends('layouts/layoutMaster')

@section('title', 'Edit')
@section('vendor-style')
{{--
<link rel="stylesheet" href="{{asset('assets/vendor/libs/swiper/swiper.scss')}}" /> --}}
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/animate-css/animate.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}" />
<link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/dropzone@5.9.3/dist/dropzone.min.css" rel="stylesheet">
@endsection

{{-- @section('page-style')
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/cards-statistics.scss')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/cards-analytics.scss')}}">
@endsection --}}

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/swiper/swiper.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
<script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/jquery/jquery.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/dropzone@5.9.3/dist/dropzone.min.js"></script>

@endsection

@section('page-script')
<script src="{{asset('assets/js/forms-extras.js')}}"></script>
<script src="{{asset('assets/js/dashboards-analytics.js')}}"></script>
<script src="{{asset('assets/js/extended-ui-sweetalert2.js')}}"></script>

@endsection
@section('content')
@include('sweetalert::alert')

<form action="{{ route('sewa.update', $item->transaksi_id)}}" id="sewaForms" method="POST"
  enctype="multipart/form-data">
  @method('PUT')
  @csrf
  <div class="d-flex justify-content-between mb-4">
    <h4>Jenis Sewa : {{ $item->Jenis->jenis_nama ?? '' }}</h4>
    <div class="badge bg-label-primary rounded-pill h-50">Edit Transaksi Sewa</div>
  </div>

  <div class="card mb-4">
    <input type="hidden" name="jenis_id" value="{{ $item->Jenis->jenis_nama ?? '' }}">
    <div
      class="card-header sticky-element bg-label-secondary d-flex justify-content-sm-between align-items-sm-center flex-column flex-sm-row">
      {{-- <div class="card-header d-flex align-items-center justify-content-between"> --}}
        <h5 class="mb-0">Edit Data Sewa</h5> <i class="text-black float-end"></i>
      </div>
      <div class="card-body p-5">
        <div class="d-flex justify-content-between">
          <h6 class="mt-3 text-primary">1. Ubah Jenis Sewa</h6>
          <div class="badge bg-label-danger rounded-pill h-50 mt-2">Perhatikan: (*) Wajib diisi</div>
        </div>
        <div class="form-floating form-floating-outline mb-3 mt-2">
          <select id="jenis_id" name="jenis_id" class="select2 form-select form-select" data-allow-clear="true">
            <option value="{{ $item->jenis_id }}">{{ $item->Jenis->jenis_nama ?? '' }}</option>
            <!-- Default option without value -->
            @foreach ($jenis as $jns)
            <option value="{{ $jns->jenis_id }}">{{ $jns->jenis_nama ?? '' }}</option>
            @endforeach
          </select>
        </div>
        <div class="d-flex justify-content-between">
          <h6 class="mt-3 text-primary">2. Perjanjian Sewa</h6>
        </div>
        <hr class="my-4 mx-n4">
        <div class="row mt-1">
          <div class="col-lg-4 col-sm-6">
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control" id="nomor_kode_barang" name="nomor_kode_barang"
                placeholder="Kode Barang" value="{{ $item->nomor_kode_barang }}" />
              <label for="nomor_kode_barang">Kode Barang </label>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6">
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control" id="nomor_register" name="nomor_register"
                placeholder="No. Register" value="{{ $item->nomor_register }}" />
              <label for="nomor_register">No. Register </label>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6">
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control" id="sertipikat" name="sertipikat" placeholder="Sertifikat"
                value="{{ $item->sertipikat }}" />
              <label for="sertipikat">Sertifikat </label>
            </div>
          </div>
        </div>

        <div class="row mt-1">
          <div class="col-lg-4 col-sm-6">
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control" id="jumlah_bidang_sewa_bagian" name="jumlah_bidang_sewa_bagian"
                placeholder="Jumlah Bidang Sewa Sebagian" value="{{ $item->jumlah_bidang_sewa_bagian }}" />
              <label for="jumlah_bidang_sewa_bagian">Jumlah Bidang Sewa Sebagian <span
                  style="color: red">*</span></label>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6">
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control" id="luas_total_sertipikat" name="luas_total_sertipikat"
                placeholder="Total Luas Sertifikat" value="{{ $item->luas_total_sertipikat }}" />
              <label for="luas_total_sertipikat">Total Luas Sertifikat </label>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6">
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control" id="luas_yang_disewa" name="luas_yang_disewa"
                placeholder="Luas yang Disewa" value="{{ $item->luas_yang_disewa }}" />
              <label for="luas_yang_disewa">Luas yang Disewa </label>
            </div>
          </div>
        </div>

        <div class="row mt-1">
          <div class="col-lg-4 col-sm-6">
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control" id="jumlah_bidang_sewa_keseluruhan"
                name="jumlah_bidang_sewa_keseluruhan" placeholder="Jumlah Bidang Sewa Keseluruhan"
                value="{{ $item->jumlah_bidang_sewa_keseluruhan }}" />
              <label for="jumlah_bidang_sewa_keseluruhan">Jumlah Bidang Sewa Keseluruhan <span
                  style="color: red">*</span></label>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6">
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control" id="jangka_waktu_kerjasama" name="jangka_waktu_kerjasama"
                placeholder="Jangka Waktu Kerjasama" value="{{ $item->jangka_waktu_kerjasama }}" />
              <label for="jangka_waktu_kerjasama">Jangka Waktu Kerjasama </label>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6">
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control" id="tahun_peninjauan_berikutnya"
                value="{{ $item->tahun_peninjauan_berikutnya }}" name="tahun_peninjauan_berikutnya"
                placeholder="Tahun Peninjauan Berikutnya" />
              <label for="tahun_peninjauan_berikutnya">Tahun Peninjauan Berikutnya <span
                  style="color: red">*</span></label>
            </div>
          </div>
        </div>
        <div class="row mt-1">
          <div class="col-lg-4 col-sm-6">
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control" id="desa" name="desa" placeholder="Input Desa"
                value="{{ $item->desa }}" />
              <label for="desa">Desa</label>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6">
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control" id="kecamatan" name="kecamatan" placeholder="Kecamatan"
                value="{{ $item->kecamatan }}" />
              <label for="kecamatan">Kecamatan</label>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6">
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control" id="kabupaten" name="kabupaten" placeholder="Kabupaten / Kota"
                value="{{ $item->kabupaten }}" />
              <label for="kabupaten">Kabupaten / Kota </label>
            </div>
          </div>
        </div>
        <div class="mt-1">
          <div class="col-lg-12 col-sm-6 mb-1">
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control form-control-sm" id="lokasi" name="lokasi" placeholder="Lokasi"
                value="{{ $item->lokasi }}" />
              <label for="lokasi">Lokasi </label>
            </div>
          </div>
          <div class="col-lg-12 col-sm-6">
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control form-control-sm" value="{{ $item->peruntukan }}" id="peruntukan"
                name="peruntukan" placeholder="Peruntukan" />
              <label for="peruntukan">Peruntukan </label>
            </div>
          </div>
        </div>
        {{------------ IDENTITAS ----------------------------------------------------------------- IDENTITAS --}}

        <h6 class="mt-4 text-primary">3. Identitas Penyewa</h6>
        <hr class="my-4 mx-n4">

        <div class="row mt-1">
          <div class="col-lg-4 col-sm-6">
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control" id="NIK" name="NIK" value="{{ $item->NIK }}"
                placeholder="NIK Pengguna" maxlength="17" />
              <label for="NIK">NIK </label>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6">
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control" id="nama_pengguna" name="nama_pengguna"
                placeholder="Nama Pengguna" value="{{ $item->nama_pengguna }}" />
              <label for="nama_pengguna">Nama Pengguna </label>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6">
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control" id="nomor_telepon" name="nomor_telepon"
                placeholder="Nomor Telepon" value="{{ $item->nomor_telepon }}" />
              <label for="nomor_telepon">Nomor Telepon </label>
            </div>
          </div>
        </div>

        <div class="row mt-1">
          <div class="col-lg-4 col-sm-6">
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control" value="{{ $item->email }}" id="email" name="email"
                placeholder="Email" />
              <label for="email">Email </label>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6">
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control" value="{{ $item->umur }}" id="umur" name="umur"
                placeholder="Umur" />
              <label for="umur">Umur</label>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6">
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control" id="pekerjaan" value="{{ $item->pekerjaan }}" name="pekerjaan"
                placeholder="Pekerjaan" />
              <label for="pekerjaan">Pekerjaan </label>
            </div>
          </div>
        </div>
        <div class="mt-1">
          <div class="col-lg-12 col-sm-6">
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control form-control-sm" value="{{ $item->alamat }}" id="alamat"
                name="alamat" placeholder="Alamat" />
              <label for="alamat">Alamat Lengkap </label>
            </div>
          </div>
          {{------------ PEMBAYARAN ----------------------------------------------------------------- PEMBAYARAN --}}
          <h6 class="mt-5 text-primary">4. Jatuh Tempo dan Pembayaran</h6>
          <hr class="my-4 mx-n4">
          <div class="row">
            <div class="col-lg-8 col-sm-6">
              <div class="col mt-2">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" id="jatuh_tempo_pembangunan_belum"
                    name="jatuh_tempo_pembangunan" value="belum" {{ $item->jatuh_tempo_pembangunan=== 'belum' ?
                  'checked' : '' }} />
                  <label class="form-check-label" for="jatuh_tempo_pembangunan_belum">
                    Belum Jatuh Tempo Pembayaran
                  </label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" id="jatuh_tempo_pembangunan_sudah"
                    name="jatuh_tempo_pembangunan" value="sudah" {{ $item->jatuh_tempo_pembangunan=== 'sudah' ?
                  'checked' : '' }} />
                  <label class="form-check-label" for="jatuh_tempo_pembangunan_sudah">
                    Sudah Jatuh Tempo Pembayaran
                  </label>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-sm-6">
              <div class="form-floating form-floating-outline mb-3">
                <input type="date" class="form-control" id="jatuh_tempo_pembayaran" name="jatuh_tempo_pembayaran"
                  placeholder="Jatuh Tempo Pembayaran" value="{{ $item->jatuh_tempo_pembayaran }}" />
                <label for="jatuh_tempo_pembayaran">Jatuh Tempo Pembayaran </label>
              </div>
            </div>

          </div>

          <div class="row mt-2">
            <div class="col-lg-4 col-sm-6">
              <div class="form-floating form-floating-outline mb-3">
                <select id="sistem_id" name="sistem_id" class="select2 form-select form-select" data-allow-clear="true">
                  <option value="{{ $item->sistem_id }}">{{ $item->SistemBayar->sistem_pembayaran ?? '' }}</option>
                  <!-- Default option without value -->
                  @foreach ($sistem as $sts)
                  <option value="{{ $sts->sistem_id }}">{{ $sts->sistem_pembayaran ?? '' }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-lg-4 col-sm-6">
              <div class="form-floating form-floating-outline mb-3">
                <input type="date" class="form-control" value="{{ $item->jangka_waktu_mulai }}" id="jangka_waktu_mulai"
                  name="jangka_waktu_mulai" placeholder="Jangka Waktu Mulai" />
                <label for="jangka_waktu_mulai">Jangka Waktu Mulai </label>
              </div>
            </div>
            <div class="col-lg-4 col-sm-6">
              <div class="form-floating form-floating-outline mb-3">
                <input type="date" class="form-control" value="{{ $item->jangka_waktu_selesai }}"
                  id="jangka_waktu_selesai" name="jangka_waktu_selesai" placeholder="Jangka Waktu Mulai" />
                <label for="jangka_waktu_selesai">Jangka Waktu Selesai </label>
              </div>
            </div>
          </div>

          <div class="row mt-1">
            <div class="col-lg-4 col-sm-6">
              <div class="input-group input-group-merge">
                <span class="input-group-text">Rp.</span>
                <div class="form-floating form-floating-outline">
                  <input type="text" class="form-control" placeholder="Besaran Sewa (Number)" id="besar_sewa"
                    name="besar_sewa" value="{{ number_format($item->besar_sewa, 0, ',', '.') }}"
                    oninput="formatRupiah(this)" onkeydown="allowOnlyNumbers(event)" />
                  <label>Besaran Sewa </label>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-sm-6">
              <div class="form-floating form-floating-outline mb-3">
                <input type="number" class="form-control" id="besar_sewa_per" name="besar_sewa_per" placeholder="%"
                  value="{{ $item->besar_sewa_per }}" />
                <label for="besar_sewa_per">Keterangan Besaran Sewa</label>
              </div>
            </div>
            <div class="col-lg-4 col-sm-6">
              <div class="input-group input-group-merge">
                <span class="input-group-text">Rp.</span>
                <div class="form-floating form-floating-outline">
                  <input type="text" class="form-control" placeholder="Kontribusi Awal (Number)" id="kontribusi_awal"
                    name="kontribusi_awal" value="{{ number_format($item->kontribusi_awal, 0, ',', '.') }}"
                    oninput="formatRupiah(this)" onkeydown="allowOnlyNumbers(event)" />
                  <label>Kontribusi Awal </label>
                </div>
              </div>
            </div>
          </div>
          <div class=" row mt-1">
            <div class="col-lg-12 col-sm-6">
              <div class="form-floating form-floating-outline mb-3">
                <input type="text" class="form-control form-control-sm" id="keterangan" name="keterangan"
                  placeholder="Keterangan" value="{{ $item->keterangan }}" />
                <label for="keterangan">Keterangan </label>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="mt-2 p-5 d-flex justify-content-between">
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Kembali</a>
        <button type="submit" class="btn btn-primary">Update Data</button>
      </div>
    </div>
  </div>
</form>
<script src="{{asset('assets/vendor/libs/jquery/jquery.js')}}"></script>

<script>
  function allowOnlyNumbers(event) {
    const keyCode = event.which || event.keyCode;
    const key = String.fromCharCode(keyCode);

    // Allow backspace, delete, tab, arrow keys, and numeric keys only
    if (!/[\d]/.test(key) && keyCode !== 8 && keyCode !== 9 && keyCode !== 37 && keyCode !== 39) {
      event.preventDefault();
    }
  }

  function formatRupiah(input) {
    // Remove non-numeric characters except for digits
    let value = input.value.replace(/[^\d]/g, '');

    // Format the value with thousands separators if there's a value
    if (value) {
      input.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }
  }
</script>
@endsection