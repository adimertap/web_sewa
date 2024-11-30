@php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
@endphp
@php
$configData = Helper::appClasses();
@endphp
@extends('layouts/layoutMaster')

@section('title', 'Tambah')
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

<form action="{{ route('sewa.store')}}" id="sewaForm" method="POST" enctype="multipart/form-data">
  @csrf
  <div class="d-flex justify-content-between mb-4">
    <h4>Jenis Sewa : {{ $jenis->jenis_nama ?? '' }}</h4>
    <div class="badge bg-label-primary rounded-pill h-50">Transaksi Baru</div>
  </div>

  <div class="card mb-4">
    <input type="hidden" name="jenis_id" value="{{ $jenis->jenis_nama ?? '' }}">
    <div
      class="card-header sticky-element bg-label-secondary d-flex justify-content-sm-between align-items-sm-center flex-column flex-sm-row">
      {{-- <div class="card-header d-flex align-items-center justify-content-between"> --}}
        <h5 class="mb-0">Tambah Data Sewa</h5> <i class="text-black float-end">Tanggal: {{ $dateNow }}</i>
      </div>
      <div class="card-body p-5">
        <div class="d-flex justify-content-between">
          <h6 class="mt-3 text-primary">1. Perjanjian Sewa</h6>
          <div class="badge bg-label-danger rounded-pill h-50 mt-2">Perhatikan: (*) Wajib diisi</div>
        </div>
        <hr class="my-4 mx-n4">
        <div class="row mt-1">
          <div class="col-lg-4 col-sm-6">
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control" id="nomor_perjanjian" name="nomor_perjanjian"
                placeholder="Nomor Perjanjian Sewa" />
              <label for="nomor_perjanjian">Nomor Perjanjian Sewa <span style="color: red">*</span></label>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6">
            <div class="form-floating form-floating-outline mb-3">
              <input type="date" class="form-control" id="tanggal_perjanjian" name="tanggal_perjanjian"
                placeholder="Tanggal Perjanjian Sewa" />
              <label for="tanggal_perjanjian">Tanggal Perjanjian Sewa <span style="color: red">*</span></label>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6">
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control" id="nomor_kode_barang" name="nomor_kode_barang"
                placeholder="Kode Barang" />
              <label for="nomor_kode_barang">Kode Barang <span style="color: red">*</span></label>
            </div>
          </div>
        </div>

        <div class="row mt-1">
          <div class="col-lg-4 col-sm-6">
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control" id="nomor_register" name="nomor_register"
                placeholder="No. Register" />
              <label for="nomor_register">No. Register <span style="color: red">*</span></label>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6">
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control" id="sertipikat" name="sertipikat" placeholder="Sertifikat" />
              <label for="sertipikat">Sertifikat <span style="color: red">*</span></label>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6">
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control" id="jumlah_bidang_sewa_bagian" name="jumlah_bidang_sewa_bagian"
                placeholder="Jumlah Bidang Sewa Sebagian" />
              <label for="jumlah_bidang_sewa_bagian">Jumlah Bidang Sewa Sebagian <span
                  style="color: red">*</span></label>
            </div>
          </div>
        </div>

        <div class="row mt-1">
          <div class="col-lg-4 col-sm-6">
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control" id="luas_total_sertipikat" name="luas_total_sertipikat"
                placeholder="Total Luas Sertifikat" />
              <label for="luas_total_sertipikat">Total Luas Sertifikat <span style="color: red">*</span></label>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6">
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control" id="luas_yang_disewa" name="luas_yang_disewa"
                placeholder="Luas yang Disewa" />
              <label for="luas_yang_disewa">Luas yang Disewa <span style="color: red">*</span></label>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6">
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control" id="jumlah_bidang_sewa_keseluruhan"
                name="jumlah_bidang_sewa_keseluruhan" placeholder="Jumlah Bidang Sewa Keseluruhan" />
              <label for="jumlah_bidang_sewa_keseluruhan">Jumlah Bidang Sewa Keseluruhan <span
                  style="color: red">*</span></label>
            </div>
          </div>
        </div>
        <div class="row mt-1">
          <div class="col-lg-12 col-sm-6">
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control form-control-sm" id="lokasi" name="lokasi" placeholder="Lokasi" />
              <label for="lokasi">Lokasi <span style="color: red">*</span></label>
            </div>
          </div>

        </div>
        <div class="row">
          <div class="col-lg-4 col-sm-6">
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control" id="kabupaten" name="kabupaten" placeholder="Kabupaten / Kota" />
              <label for="kabupaten">Kabupaten / Kota <span style="color: red">*</span></label>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6">
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control" id="jangka_waktu_kerjasama" name="jangka_waktu_kerjasama"
                placeholder="Jangka Waktu Kerjasama" />
              <label for="jangka_waktu_kerjasama">Jangka Waktu Kerjasama <span style="color: red">*</span></label>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6">
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control" id="tahun_peninjauan_berikutnya"
                name="tahun_peninjauan_berikutnya" placeholder="Tahun Peninjauan Berikutnya" />
              <label for="tahun_peninjauan_berikutnya">Tahun Peninjauan Berikutnya <span
                  style="color: red">*</span></label>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6">

          </div>
        </div>
        {{------------ IDENTITAS ----------------------------------------------------------------- IDENTITAS --}}

        <h6 class="mt-4 text-primary">2. Identitas Penyewa</h6>
        <hr class="my-4 mx-n4">

        <div class="row mt-1">
          <div class="col-lg-4 col-sm-6">
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control" id="NIK" name="NIK" placeholder="NIK Pengguna" maxlength="17" />
              <label for="NIK">NIK <span style="color: red">*</span></label>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6">
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control" id="nama_pengguna" name="nama_pengguna"
                placeholder="Nama Pengguna" />
              <label for="nama_pengguna">Nama Pengguna <span style="color: red">*</span></label>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6">
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control" id="nomor_telepon" name="nomor_telepon"
                placeholder="Nomor Telepon" />
              <label for="nomor_telepon">Nomor Telepon <span style="color: red">*</span></label>
            </div>
          </div>
        </div>

        <div class="row mt-1">
          <div class="col-lg-4 col-sm-6">
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control" id="email" name="email" placeholder="Email" />
              <label for="email">Email </label>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6">
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control" id="umur" name="umur" placeholder="Umur" />
              <label for="umur">Umur</label>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6">
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" placeholder="Pekerjaan" />
              <label for="pekerjaan">Pekerjaan </label>
            </div>
          </div>
        </div>
        <div class="mt-1">
          <div class="col-lg-12 col-sm-6">
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control form-control-sm" id="alamat" name="alamat" placeholder="Alamat" />
              <label for="alamat">Alamat Lengkap </label>
            </div>
          </div>

          <div class="mt-1">
            <div class="col-lg-12 col-sm-6">
              <div class="form-floating form-floating-outline mb-3">
                <input type="text" class="form-control form-control-sm" id="peruntukan" name="peruntukan"
                  placeholder="Peruntukan" />
                <label for="peruntukan">Peruntukan <span style="color: red">*</span></label>
              </div>
            </div>
          </div>
          {{------------ PEMBAYARAN ----------------------------------------------------------------- PEMBAYARAN --}}
          <h6 class="mt-5 text-primary">3. Jatuh Tempo dan Pembayaran</h6>
          <hr class="my-4 mx-n4">
          <div class="row">
            <div class="col-lg-8 col-sm-6">
              {{-- <label class="form-check-label">Sudah Jatuh Tempo Pembangunan / Belum</label> --}}
              <div class="col mt-2">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" id="jatuh_tempo_pembangunan_belum"
                    name="jatuh_tempo_pembangunan" value="belum" checked />
                  <label class="form-check-label" for="jatuh_tempo_pembangunan_belum">Belum Jatuh Tempo
                    Pembagunan</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" id="jatuh_tempo_pembangunan_sudah"
                    name="jatuh_tempo_pembangunan" value="sudah" />
                  <label class="form-check-label" for="jatuh_tempo_pembangunan_sudah">Sudah Jatuh Tempo
                    Pembangunan</label>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-sm-6">
              <div class="form-floating form-floating-outline mb-3">
                <input type="date" class="form-control" id="jatuh_tempo_pembayaran" name="jatuh_tempo_pembayaran"
                  placeholder="Jatuh Tempo Pembayaran" />
                <label for="jatuh_tempo_pembayaran">Jatuh Tempo Pembayaran <span style="color: red">*</span></label>
              </div>
            </div>

          </div>

          <div class="row mt-2">
            <div class="col-lg-4 col-sm-6">
              <div class="form-floating form-floating-outline mb-3">
                <input type="text" class="form-control" id="sistem_pembayaran" name="sistem_pembayaran"
                  placeholder="Sistem Pembayaran" />
                <label for="sistem_pembayaran">Sistem Pembayaran <span style="color: red">*</span></label>
              </div>
            </div>
            <div class="col-lg-4 col-sm-6">
              <div class="form-floating form-floating-outline mb-3">
                <input type="date" class="form-control" id="jangka_waktu_mulai" name="jangka_waktu_mulai"
                  placeholder="Jangka Waktu Mulai" />
                <label for="jangka_waktu_mulai">Jangka Waktu Mulai <span style="color: red">*</span></label>
              </div>
            </div>
            <div class="col-lg-4 col-sm-6">
              <div class="form-floating form-floating-outline mb-3">
                <input type="date" class="form-control" id="jangka_waktu_selesai" name="jangka_waktu_selesai"
                  placeholder="Jangka Waktu Mulai" />
                <label for="jangka_waktu_selesai">Jangka Waktu Selesai <span style="color: red">*</span></label>
              </div>
            </div>
          </div>

          <div class="row mt-1">
            <div class="col-lg-4 col-sm-6">
              <div class="input-group input-group-merge">
                <span class="input-group-text">Rp.</span>
                <div class="form-floating form-floating-outline">
                  <input type="number" class="form-control" placeholder="Besaran Sewa (Number)" id="besar_sewa"
                    name="besar_sewa" />
                  <label>Besaran Sewa <span style="color: red">*</span></label>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-sm-6">
              <div class="form-floating form-floating-outline mb-3">
                <input type="text" class="form-control" id="besar_sewa_per" name="besar_sewa_per"
                  placeholder="Per Tahun Naik ..." />
                <label for="besar_sewa_per">Keterangan Besaran Sewa<span style="color: red">*</span></label>
              </div>
            </div>
            <div class="col-lg-4 col-sm-6">
              <div class="input-group input-group-merge">
                <span class="input-group-text">Rp.</span>
                <div class="form-floating form-floating-outline">
                  <input type="number" class="form-control" placeholder="Kontribusi Awal (Number)" id="kontribusi_awal"
                    name="kontribusi_awal" />
                  <label>Kontribusi Awal <span style="color: red">*</span></label>
                </div>
              </div>
            </div>
          </div>
          <div class="row mt-1">
            <div class="col-lg-12 col-sm-6">
              <div class="form-floating form-floating-outline mb-3">
                <input type="text" class="form-control form-control-sm" id="keterangan" name="keterangan"
                  placeholder="Keterangan" />
                <label for="keterangan">Keterangan <span style="color: red">*</span></label>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


    <!-- Collapsible Section -->
    <div class="row my-4 mt-4">
      <div class="col">
        <div class="accordion" id="collapsibleSection">
          {{-- PEMBAYARAN --}}
          {{-- PEMBAYARAN --}}
          {{-- PEMBAYARAN --}}
          {{-- PEMBAYARAN --}}

          <div class="card accordion-item">
            <h2 class="accordion-header" id="headingDeliveryAddress">
              <button class="accordion-button sticky-element bg-label-secondary p-4" type="button"
                data-bs-toggle="collapse" data-bs-target="#collapseDeliveryAddress" aria-expanded="true"
                aria-controls="collapseDeliveryAddress">
                Detail Pembayaran (Click to Expand)</button>
            </h2>
            <div id="collapseDeliveryAddress" class="accordion-collapse collapse show"
              aria-labelledby="headingDeliveryAddress" data-bs-parent="#collapsibleSection">
              <div class="accordion-body mt-4">
                <p class="mb-3">Detail Pembayaran Tahun ke Tahun, Klik Add untuk lebih dari satu record</p>
                <form id="repeaterForm">
                  <div data-repeater-list="group-a">
                    <div id="repeaterContainer">
                      <div class="row repeater-item mb-2">
                        <div class="col-lg-3 col-xl-2 col-12 mb-0">
                          <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control form-control-sm" name="group-a[0][pembayaran_tahun]"
                              placeholder="Tahun" />
                            <label for="pembayaran_tahun">Tahun</label>
                          </div>
                        </div>
                        <div class="col-lg-4 col-xl-3 col-12 mb-0">
                          <div class="input-group input-group-merge">
                            <span class="input-group-text">Rp.</span>
                            <div class="form-floating form-floating-outline">
                              <input type="number" class="form-control" placeholder="Nominal Pembayaran"
                                name="group-a[0][nominal]" />
                              <label>Nominal <span style=" color: red">*</span></label>
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-4 col-xl-3 col-12 mb-0">
                          <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control form-control-sm" name="group-a[0][keterangan]"
                              placeholder="Keterangan" />
                            <label for="keterangan">Keterangan</label>
                          </div>
                        </div>
                        <div class="col-lg-3 col-xl-2 col-12 mb-0">
                          <div class="form-floating form-floating-outline">
                            <input type="date" class="form-control form-control-sm"
                              name="group-a[0][pembayaran_tanggal]" placeholder="Tanggal" />
                            <label for="pembayaran_tanggal">Tanggal</label>
                          </div>
                        </div>
                        <div class="col-lg-12 col-xl-2 col-12 d-flex align-items-center mb-0">
                          <button type="button" class="btn btn-sm mb-4 btn-outline-danger remove-item">
                            <i class="mdi mdi-close me-1"></i>
                            <span class="align-middle">Delete</span>
                          </button>
                        </div>
                      </div>
                      <hr>
                    </div>
                  </div>
                  <div class="mb-0">
                    <button type="button" class="btn btn-sm btn-primary" id="addItem">
                      <i class="mdi mdi-plus me-1"></i>
                      <span class="align-middle">Add</span>
                    </button>
                  </div>
                  {{-- <div class="mt-4">
                    <button type="submit" class="btn btn-success">Submit</button>
                  </div> --}}
              </div>
            </div>
          </div>
          {{-- KENAIKAN --}}
          {{-- KENAIKAN --}}
          {{-- KENAIKAN --}}
          {{-- KENAIKAN --}}

          <div class="card accordion-item mt-3">
            <h2 class="accordion-header" id="kenaikanLayout">
              <button class="accordion-button collapsed bg-label-secondary p-4" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapsekenaikanLayout" aria-expanded="false" aria-controls="collapsekenaikanLayout">
                Detail Kenaikan (Click to Expand)</button>
            </h2>
            <div id="collapsekenaikanLayout" class="accordion-collapse collapse" aria-labelledby="kenaikanLayout"
              data-bs-parent="#collapsibleSection">
              <div class="accordion-body mt-4">
                <p class="mb-3">Detail Kenaikan Tahun ke Tahun, Klik Add untuk lebih dari satu record</p>
                <form id="kenaikanForm">
                  <div data-repeater-list="kenaikan-a">
                    <div id="repeaterContainerKenaikan">
                      <div class="row repeater-item-kenaikan mb-2">
                        <div class="col-lg-3 col-xl-2 col-12 mb-0">
                          <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control form-control-sm" name="kenaikan-a[0][tahun_ke]"
                              placeholder="Tahun" />
                            <label for="tahun_ke">Tahun Ke-</label>
                          </div>
                        </div>
                        <div class="col-lg-6 col-xl-3 col-12 mb-0">
                          <div class="input-group input-group-merge">
                            <span class="input-group-text">Rp.</span>
                            <div class="form-floating form-floating-outline">
                              <input type="number" class="form-control" placeholder="Nominal Kenaikan"
                                name="kenaikan-a[0][besaran]" />
                              <label>Nominal Kenaikan <span style=" color: red">*</span></label>
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-12 col-xl-2 col-12 d-flex align-items-center mb-0">
                          <button type="button" class="btn btn-sm mb-4 btn-outline-danger remove-item-kenaikan">
                            <i class="mdi mdi-close me-1"></i>
                            <span class="align-middle">Delete</span>
                          </button>
                        </div>
                      </div>
                      <hr>
                    </div>
                  </div>
                  <div class="mb-0">
                    <button type="button" class="btn btn-sm btn-primary" id="addItemKenaikan">
                      <i class="mdi mdi-plus me-1"></i>
                      <span class="align-middle">Add</span>
                    </button>
                  </div>
                  {{-- <div class="mt-4">
                    <button type="submit" class="btn btn-success">Submit</button>
                  </div> --}}
              </div>
            </div>
          </div>
          {{-- FILE PENDUKUNG --}}
          {{-- FILE PENDUKUNG --}}
          {{-- FILE PENDUKUNG --}}
          {{-- FILE PENDUKUNG --}}
          {{-- FILE PENDUKUNG --}}

          <div class="card accordion-item mt-3">
            <h2 class="accordion-header" id="headingDeliveryOptions">
              <button class="accordion-button collapsed bg-label-secondary p-4" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseDeliveryOptions" aria-expanded="false" aria-controls="collapseDeliveryOptions">
                Upload Dokumen Pendukung (Click to Expand)</button>
            </h2>
            <div id="collapseDeliveryOptions" class="accordion-collapse collapse"
              aria-labelledby="headingDeliveryOptions" data-bs-parent="#collapsibleSection">
              <div class="accordion-body">
                <div class="mt-3">
                  <i>Upload Dokumen (bisa lebih dari satu file)</i>
                </div>
                <div id="dropzoneArea" class="dropzone-custom mt-1">
                  <input type="file" name="file_pendukung[]" id="file_pendukung" multiple hidden>
                  <div class="dz-message">
                    <h5 class="text-muted">Drop files here or click to upload</h5>
                    <p class="text-muted">(Maximum file size: 1MB)</p>
                  </div>
                  <div id="loadingIndicator" class="loading-indicator d-none">
                    <div class="spinner-border text-primary" role="status">
                      <span class="visually-hidden">Uploading...</span>
                    </div>
                    <p>Uploading, please wait...</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="mt-5 d-flex justify-content-between">
      <a href="{{ route('dashboard') }}" class="btn btn-secondary">Kembali</a>
      <button type="submit" class="btn btn-primary">Save Data</button>
    </div>

  </div>
</form>


<style>
  /* Dropzone container styling */
  #dropzoneArea {
    border: 2px dashed #ccc;
    padding: 30px;
    text-align: center;
    position: relative;
    cursor: pointer;
    /* Ensures the dropzone looks interactive */
  }

  /* Horizontal layout for file previews */
  .dz-preview {
    display: inline-block;
    width: 120px;
    margin: 10px;
    text-align: center;
    vertical-align: top;
  }

  /* Image preview styling */
  .dz-image img,
  .pdf-icon {
    width: 100%;
    height: 100px;
    object-fit: contain;
    border-radius: 8px;
    display: block;
  }

  /* Filename and size styling */
  .dz-details {
    margin-top: 5px;
    font-size: 12px;
  }

  .dz-filename {
    margin-top: 5px;
    word-break: break-word;
    font-weight: bold;
  }

  .dz-size {
    margin-top: 3px;
    font-size: 12px;
    color: #777;
  }

  /* Remove button styling */
  .dz-remove-btn {
    margin-top: 10px;
    background-color: #ff4d4f;
    color: white;
    border: none;
    padding: 5px 10px;
    border-radius: 4px;
    font-size: 12px;
    cursor: pointer;
    width: 100%;
  }

  .dz-remove-btn:hover {
    background-color: #d9363e;
  }

  /* Loading indicator styling */
  .loading-indicator {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    margin-top: 20px;
  }

  .loading-indicator p {
    margin-top: 10px;
    font-size: 14px;
    color: #6c757d;
  }

  /* Hide by default */
  .d-none {
    display: none !important;
  }

  /* Hide success and error icons */
  .dz-success-mark,
  .dz-error-mark {
    display: none !important;
  }

  /* File preview container adjustments for a cleaner look */
  .dz-preview {
    border: none;
    background: none;
  }
</style>



<script src="{{asset('assets/vendor/libs/jquery/jquery.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/dropzone@5.9.3/dist/dropzone.min.js"></script>

<script>
  Dropzone.autoDiscover = false;
  let dropzone;
  document.addEventListener("DOMContentLoaded", function () {
    dropzone = new Dropzone("#dropzoneArea", {
      url: "/upload", // Set a dummy URL to prevent the "No URL provided" error
      autoProcessQueue: false, // Prevent Dropzone from auto-uploading
      paramName: "file_pendukung", // Correct the paramName here
      maxFilesize: 20 // Maximum file size in MB
        ,
      acceptedFiles: ".jpeg,.jpg,.png,.pdf,.doc,.docx,.xls,.xlsx",
      addRemoveLinks: true,
      dictRemoveFile: "Remove File",
      dictDefaultMessage: "Drop files here or click to upload",
      dictFileTooBig: "File is too big. Maximum file size is 1MB.",
      previewTemplate: `
      <div class="dz-preview dz-file-preview">
        <div class="dz-image">
          <img data-dz-thumbnail />
        </div>
        <div class="dz-details">
          <p class="dz-filename"><span data-dz-name></span></p>
          <p class="dz-size" data-dz-size></p>
        </div>
        <button class="dz-remove-btn btn btn-danger btn-sm" data-dz-remove>Remove</button>
      </div>
    `,
      init: function () {
        const inputFile = document.getElementById("file_pendukung");
        const pdfIconPath = "{{ asset('assets/img/pdf.png') }}"; // Path to the PDF icon
        const docIconPath = "{{ asset('assets/img/doc.png') }}"; // Path to the DOC icon
        const excelIconPath = "{{ asset('assets/img/xls.png') }}"; // Path to the Excel icon
        // File added event
        this.on("addedfile", function (file) {

          const previewElement = file.previewElement;
          const imageContainer = previewElement.querySelector(".dz-image img");

          // Customize icons for specific file types
          if (file.type === "application/pdf") {
            const pdfIcon = document.createElement("img");
            pdfIcon.src = pdfIconPath;
            pdfIcon.alt = "PDF File";
            pdfIcon.classList.add("pdf-icon");
            imageContainer.parentNode.replaceChild(pdfIcon, imageContainer);
          } else if (
            file.type === "application/msword" ||
            file.type ===
            "application/vnd.openxmlformats-officedocument.wordprocessingml.document"
          ) {
            const docIcon = document.createElement("img");
            docIcon.src = docIconPath; // Replace with your Word icon path
            docIcon.alt = "Word Document";
            docIcon.classList.add("pdf-icon");
            imageContainer.parentNode.replaceChild(docIcon, imageContainer);
          } else if (
            file.type === "application/vnd.ms-excel" ||
            file.type ===
            "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
          ) {
            const excelIcon = document.createElement("img");
            excelIcon.src = excelIconPath; // Replace with your Excel icon path
            excelIcon.alt = "Excel File";
            excelIcon.classList.add("pdf-icon");
            imageContainer.parentNode.replaceChild(excelIcon, imageContainer);
          } else if (file.type === "image/jpeg" || file.type === "image/png") {
            imageContainer.style.display = "block";
          }

          const dataTransfer = new DataTransfer();
          this.files.forEach((dzFile) => {
            dataTransfer.items.add(dzFile);
          });
          inputFile.files = dataTransfer.files;

        });

        // Bind to input file change event
        this.on("drop", function () {
          inputFile.files = this.files;
        });

        // When a file is removed
        this.on("removedfile", function (file) {
          console.log("File removed:", file);

          // Remove the file from the input element
          const dataTransfer = new DataTransfer();
          this.files.forEach((dzFile) => {
            if (dzFile !== file) {
              dataTransfer.items.add(dzFile);
            }
          });
          inputFile.files = dataTransfer.files;
        });
      },
    });
  });

  $(document).ready(function () {
    let itemCount = 1; // Initial item count for dynamic names
    let itemCountKenaikan = 1;


    // Add new repeater item
    $('#addItemKenaikan').click(function () {
      const newItemKenaikan = `
        <div class="row repeater-item-kenaikan mb-2">
            <div class="col-lg-3 col-xl-2 col-12 mb-0">
                <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control form-control-sm" name="kenaikan-a[${itemCountKenaikan}][tahun_ke]" placeholder="Tahun" />
                    <label for="tahun_ke">Tahun Ke-</label>
                </div>
            </div>
            <div class="col-lg-6 col-xl-3 col-12 mb-0">
                <div class="input-group input-group-merge">
                    <span class="input-group-text">Rp.</span>
                    <div class="form-floating form-floating-outline">
                        <input type="number" class="form-control" placeholder="Nominal Kenaikan" name="kenaikan-a[${itemCountKenaikan}][besaran]" />
                        <label>Nominal Kenaikan <span style="color: red">*</span></label>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-xl-2 col-12 d-flex align-items-center mb-0">
                <button type="button" class="btn btn-sm mb-4 btn-outline-danger remove-item-kenaikan">
                    <i class="mdi mdi-close me-1"></i>
                    <span class="align-middle">Delete</span>
                </button>
            </div>
        </div>
        <hr>`;

      $('#repeaterContainerKenaikan').append(newItemKenaikan);
      itemCountKenaikan++; // Increment for next item
    });

    // Remove repeater item
    $(document).on('click', '.remove-item-kenaikan', function () {
      $(this).closest('.repeater-item-kenaikan').next('hr').remove(); // Remove the associated <hr>
      $(this).closest('.repeater-item-kenaikan').remove();
    });



    // Add new repeater item
    $('#addItem').click(function () {
      const newItem = `
          <div class="row repeater-item">
            <div class="mb-2 col-lg-3 col-xl-2 col-12 mb-0">
              <div class="form-floating form-floating-outline">
                <input type="text" class="form-control" name="group-a[${itemCount}][pembayaran_tahun]" placeholder="Tahun" />
                <label for="pembayaran_tahun">Tahun</label>
              </div>
            </div>
              <div class="mb-2 col-lg-4 col-xl-3 col-12 mb-0">
                <div class="input-group input-group-merge">
                  <span class="input-group-text">Rp.</span>
                  <div class="form-floating form-floating-outline">
                    <input type="number" class="form-control" placeholder="Besaran Sewa (Number)"
                       name="group-a[${itemCount}][nominal]" />
                    <label>Nominal <span style="color: red">*</span></label>
                  </div>
                </div>
              </div>
               <div class="col-lg-4 col-xl-3 col-12 mb-0">
                          <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control form-control-sm" name="group-a[0][${itemCount}][keterangan]"
                              placeholder="Keterangan" />
                            <label for="keterangan">Keterangan</label>
                          </div>
                        </div>

            <div class="mb-2 col-lg-3 col-xl-2 col-12 mb-0">
              <div class="form-floating form-floating-outline">
                <input type="date" class="form-control" name="group-a[${itemCount}][pembayaran_tanggal]" placeholder="Tanggal" />
                <label for="pembayaran_tanggal">Tanggal</label>
              </div>
            </div>
            <div class="mb-2 col-lg-12 col-xl-2 col-12 d-flex align-items-center mb-0">
              <button type="button" class="btn btn-sm btn-outline-danger remove-item">
                <i class="mdi mdi-close me-1"></i>
                <span class="align-middle">Delete</span>
              </button>
            </div>
          </div>
          <hr>`;

      $('#repeaterContainer').append(newItem);
      itemCount++; // Increment for next item
    });

    // Remove repeater item
    $(document).on('click', '.remove-item', function () {
      $(this).closest('.repeater-item').next('hr').remove(); // Remove the associated <hr>
      $(this).closest('.repeater-item').remove();
    });
  });

</script>
@endsection
