@php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
@endphp
@php
$configData = Helper::appClasses();
@endphp
@extends('layouts/layoutMaster')


@section('title', 'Detail')
@section('vendor-style')
{{--
<link rel="stylesheet" href="{{asset('assets/vendor/libs/swiper/swiper.scss')}}" /> --}}
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/animate-css/animate.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}" />
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
<script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
<script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
<script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
<script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>

@endsection

@section('page-script')
<script src="{{asset('assets/js/forms-extras.js')}}"></script>
<script src="{{asset('assets/js/extended-ui-sweetalert2.js')}}"></script>
@endsection
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/app-invoice.css')}}" />
@endsection



@section('content')
@include('sweetalert::alert')

<div class="invoice-preview">
  <!-- Invoice Actions -->
  <div class="col-12 invoice-actions mb-3">
    <div class="card">
      <div class="card-body d-flex justify-content-between flex-wrap gap-3">
        <!-- Edit Data Button -->
        <div>
          <h5 class="mb-0 mt-1">Detail Data Sewa</h5>
          <p class="small text-muted mt-0">Berikut merupakan data penyewaan secara detail</p>

        </div>
        <div>
          @if($item->status == 'A')
          <a href="javascript:;" class="btn btn-primary" onclick="selesaiSewa({{ $item->transaksi_id }})">Selesai
            Sewa</a>
          <form id="selesai-sewa-{{ $item->transaksi_id }}" action="{{ route('sewa.selesai', $item->transaksi_id) }}"
            method="POST" style="display: none;">
            @csrf
          </form>
          @endif

          <a href="{{ route('sewa.edit', $item->transaksi_id) }}" class="btn btn-outline-secondary">
            <span class="d-flex align-items-center justify-content-center text-nowrap">
              <i class="mdi mdi-send-outline scaleX-n1-rtl me-1"></i>Edit Data
            </span>
          </a>
          <!-- Print Button -->
          <a class="btn btn-outline-secondary" target="_blank" href="{{route('sewa.print', $item->transaksi_id)}}">
            Print
          </a>
          <a href="javascript:;" class="btn btn-danger" onclick="deleteSewa({{ $item->transaksi_id }})">Hapus</a>
          <form id="delete-sewa-{{ $item->transaksi_id }}" action="{{ route('sewa.destroy', $item->transaksi_id) }}"
            method="POST" style="display: none;">
            @method('DELETE')
            @csrf
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="card mb-4">
    <div class="card-header p-0">
      <div class="nav-align-top">
        <ul class="nav nav-tabs nav-fill" role="tablist">
          <li class="nav-item">
            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
              data-bs-target="#navs-justified-home" aria-controls="navs-justified-home" aria-selected="true"><i
                class="tf-icons mdi mdi-home-outline me-1"></i> Data Sewa </button>
          </li>
          <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
              data-bs-target="#navs-justified-profile" aria-controls="navs-justified-profile" aria-selected="false"><i
                class="tf-icons mdi mdi-message-outline me-1"></i> Data Pembayaran
              <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-primary ms-1">
                {{ $pembayaranCount }}
              </span>
            </button>
          </li>
          <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
              data-bs-target="#navs-justified-messages" aria-controls="navs-justified-messages" aria-selected="false"><i
                class="tf-icons mdi mdi-message-text-outline me-1"></i> Data Kenaikan
              <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-primary ms-1">{{ $kenaikanCount
                }}</span>
            </button>
          </li>
        </ul>
      </div>
    </div>
    <div class="card-body">
      <div class="tab-content p-0">
        <div class="tab-pane fade show active" id="navs-justified-home" role="tabpanel">
          <div class="p-2">
            <div class="d-flex flex-column flex-md-row justify-content-between">
              <div class="mb-4 mb-md-0">
                <div class="d-flex svg-illustration align-items-center gap-2 mb-4">
                  <span class="h4 mb-0 app-brand-text fw-bold">Jenis: {{ $item->Jenis->jenis_nama }}</span>
                </div>
                <p class="mb-1">Kabupaten/Kota: <b>{{ $item->kabupaten }}</b></p>
                <p class="mb-1">Peruntukan: <i> {{ $item->peruntukan }}</i></p>
              </div>
              <div>
                {{-- <h4 class="fw-medium">Data Penyewaan</h4> --}}
                <div class="mb-1 mt-5">
                  <span>Tanggal:</span>
                  <i>{{ isset($item->Nomor[0]) ? $item->Nomor[0]->tanggal_perjanjian : '-' }}</i>
                </div>
                <div class="mb-1">
                  <span>Sistem Pembayaran:</span>
                  <b>{{ $item->SistemBayar->sistem_pembayaran }}</b>
                </div>
              </div>
            </div>
            <hr>
            <div class="row mt-4">
              <div class="col-12 col-md-12 border p-3">
                <!-- Detail Pembayaran -->
                <div class="d-flex">
                  <h6 class="p-1">1. Nomor Perjanjian:</h6>
                  <button class="btn btn-sm btn-outline-primary btn-primary h-50 ms-2" onclick="modalTambahNomor()">
                    <span class="text-nowrap">Tambah Nomor</span>
                  </button>
                </div>
                <div class="table-responsive">
                  <table class="table table-bordered small m-0" id="tableNomor">
                    <thead class="border-top">
                      <tr>
                        <th class="text-center">No.</th>
                        <th class="text-center">Nomor Perjanjian</th>
                        <th class="text-center">Tanggal Perjanjian</th>
                        <th class="text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($item->Nomor as $nomor)
                      <tr role="row" class="odd">
                        <td class="text-center">{{ $loop->iteration }}.</td>
                        <td class="text-center" data-label="nomor_perjanjian">{{ $nomor->nomor_perjanjian }}</td>
                        <td class="text-center" data-label="tanggal_perjanjian">{{ $nomor->tanggal_perjanjian }}</td>
                        <td class="text-center">
                          <div class="d-inline-block"><a href="javascript:;"
                              class="btn btn-sm btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow"
                              data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end m-0" style="">
                              <li>
                                <button class="dropdown-item edit-row-btn-nomor"
                                  data-id="{{ $nomor->transaksi_nomor_id }}" data-nomor="{{ $nomor->nomor_perjanjian }}"
                                  data-tanggal="{{ $nomor->tanggal_perjanjian }}">
                                  Edit
                                </button>

                              </li>
                              <div class="dropdown-divider"></div>
                              <li>
                                <a href="javascript:;" class="dropdown-item text-danger delete-record"
                                  onclick="deleteNomor({{ $nomor->transaksi_nomor_id }})">Hapus</a>
                                <form id="delete-nomor-{{ $nomor->transaksi_nomor_id }}"
                                  action="{{ route('sewa.nomor.delete', $nomor->transaksi_nomor_id) }}" method="POST"
                                  style="display: none;">
                                  @method('DELETE')
                                  @csrf
                                </form>
                              </li>
                            </ul>
                          </div>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>

            </div>
            <div class="row mt-4">
              <div class="col-12 col-md-6 border p-3">
                <h6 class="pb-2">2. Informasi Penyewa:</h6>
                <div class="row mb-1">
                  <div class="col-3">
                    <p class="mb-1 fw-medium">NIK</p>
                  </div>
                  <div class="col-9">
                    <p class="mb-1">: {{ $item->NIK }}</p>
                  </div>
                </div>
                <div class="row mb-1">
                  <div class="col-3">
                    <p class="mb-1 fw-medium">Nama</p>
                  </div>
                  <div class="col-9">
                    <p class="mb-1 fw-medium">: {{ $item->nama_pengguna }} </p>
                  </div>
                </div>
                <div class="row mb-1">
                  <div class="col-3">
                    <p class="mb-1 fw-medium">Telphone</p>
                  </div>
                  <div class="col-9">
                    <p class="mb-1">: {{ $item->nomor_telepon }}</p>
                  </div>
                </div>
                <div class="row mb-1">
                  <div class="col-3">
                    <p class="mb-1">Email</p>
                  </div>
                  <div class="col-9">
                    <p class="mb-1">: {{ $item->email }}</p>
                  </div>
                </div>
                <div class="row mb-1">
                  <div class="col-3">
                    <p class="mb-1 fw-medium">Umur</p>
                  </div>
                  <div class="col-9">
                    <p class="mb-1">: {{ $item->umur }} Tahun</p>
                  </div>
                </div>
                <div class="row mb-1">
                  <div class="col-3">
                    <p class="mb-1 fw-medium">Pekerjaan</p>
                  </div>
                  <div class="col-9">
                    <p class="mb-1">: {{ $item->pekerjaan }}</p>
                  </div>
                </div>
                <div class="row mb-1">
                  <div class="col-3">
                    <p class="mb-1 fw-medium">Alamat</p>
                  </div>
                  <div class="col-9">
                    <p class="mb-1">: {{ $item->alamat }}</p>
                  </div>
                </div>
              </div>

              <!-- Pembayaran dan Jatuh Tempo -->
              <div class="col-12 col-md-6 border p-3">
                <h6 class="pb-2">3. Pembayaran dan Jatuh Tempo:</h6>
                <div class="row mb-1">
                  <div class="col-5">
                    <p class="mb-1 fw-medium">Sistem Pembayaran</p>
                  </div>
                  <div class="col-7">
                    <p class="mb-1">: {{ $item->SistemBayar->sistem_pembayaran ?? '' }} </p>
                  </div>
                </div>
                <div class="row mb-1">
                  <div class="col-5">
                    <p class="mb-1 fw-medium">Jangka Waktu Mulai</p>
                  </div>
                  <div class="col-7">
                    <p class="mb-1">: {{ $item->jangka_waktu_mulai ?? '' }}</p>
                  </div>
                </div>
                <div class="row mb-1">
                  <div class="col-5">
                    <p class="mb-1 fw-medium">Jangka Waktu Selesai</p>
                  </div>
                  <div class="col-7">
                    <p class="mb-1">: {{ $item->jangka_waktu_selesai ?? '' }}</p>
                  </div>
                </div>
                <div class="row mb-1">
                  <div class="col-5">
                    <p class="mb-1 fw-medium">Sudah Jatuh Tempo Pembayaran?</p>
                  </div>
                  <div class="col-7">
                    <p class="mb-1">: {{ $item->jatuh_tempo_pembangunan ?? '' }}</p>
                  </div>
                </div>
                <div class="row mb-1">
                  <div class="col-5">
                    <p class="mb-1 fw-medium">Jatuh Tempo Pembayaran</p>
                  </div>
                  <div class="col-7">
                    <p class="mb-1">: {{ $item->jatuh_tempo_pembayaran ?? '' }}</p>
                  </div>
                </div>
                <hr>
                <div class="row mb-1">
                  <div class="col-5">
                    <p class="mb-1 fw-medium text-primary">Besaran Sewa</p>
                  </div>
                  <div class="col-7">
                    <p class="mb-1 text-primary">: Rp {{ number_format($item->besar_sewa, 0, ',', '.') }} </p>
                  </div>
                </div>
                <div class="row mb-1">
                  <div class="col-5">
                    <p class="mb-1 fw-medium  text-primary">Ket. Besaran Sewa</p>
                  </div>
                  <div class="col-7">
                    <p class="mb-1  text-primary">: {{ $item->besar_sewa_per ?? '-' }} %</p>
                  </div>
                </div>
                <div class="row mb-1">
                  <div class="col-5">
                    <p class="mb-1 fw-medium  text-primary">Kontribusi Awal</p>
                  </div>
                  <div class="col-7">
                    <p class="mb-1  text-primary">: Rp {{ number_format($item->kontribusi_awal, 0, ',', '.') }}</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="row mt-4">
              <div class="col-12 col-md-6 border p-3">
                <h6 class="pb-2">4. Detail Penyewaan:</h6>
                <div class="row mb-1">
                  <div class="col-4">
                    <p class="mb-1 fw-medium">Peruntukan</p>
                  </div>
                  <div class="col-8">
                    <p class="mb-1 fw-medium">: {{ $item->peruntukan }}</p>
                  </div>
                </div>
                <div class="row mb-1">
                  <div class="col-4">
                    <p class="mb-1 fw-medium">Kode Barang</p>
                  </div>
                  <div class="col-8">
                    <p class="mb-1">: {{ $item->nomor_kode_barang }}</p>
                  </div>
                </div>
                <div class="row mb-1">
                  <div class="col-4">
                    <p class="mb-1 fw-medium">Sertipikat</p>
                  </div>
                  <div class="col-8">
                    <p class="mb-1">: {{ $item->sertipikat }}</p>
                  </div>
                </div>
                <div class="row mb-1">
                  <div class="col-4">
                    <p class="mb-1 fw-medium">Bidang Sewa Sebagian</p>
                  </div>
                  <div class="col-8">
                    <p class="mb-1">: {{ $item->jumlah_bidang_sewa_bagian }}</p>
                  </div>
                </div>
                <div class="row mb-1">
                  <div class="col-4">
                    <p class="mb-1 fw-medium">Bidang Sewa Seluruh</p>
                  </div>
                  <div class="col-8">
                    <p class="mb-1">: {{ $item->jumlah_bidang_sewa_keseluruhan }}</p>
                  </div>
                </div>
                <div class="row mb-1">
                  <div class="col-4">
                    <p class="mb-1 fw-medium">Lokasi</p>
                  </div>
                  <div class="col-8">
                    <p class="mb-1">: {{ $item->lokasi }}</p>
                  </div>
                </div>
              </div>

              <div class="col-12 col-md-6 border p-3">
                <div class="row mb-1">
                  <div class="col-4">
                    <p class="mb-1 fw-medium">Nomor Register</p>
                  </div>
                  <div class="col-8">
                    <p class="mb-1">: {{ $item->nomor_register }}</p>
                  </div>
                </div>
                <div class="row mb-1">
                  <div class="col-4">
                    <p class="mb-1 fw-medium">Luas Total Sertipikat</p>
                  </div>
                  <div class="col-8">
                    <p class="mb-1">: {{ $item->luas_total_sertipikat }}</p>
                  </div>
                </div>
                <div class="row mb-1">
                  <div class="col-4">
                    <p class="mb-1 fw-medium">Luas yang di Sewa</p>
                  </div>
                  <div class="col-8">
                    <p class="mb-1">: {{ $item->luas_yang_disewa }}</p>
                  </div>
                </div>
                <div class="row mb-1">
                  <div class="col-4">
                    <p class="mb-1 fw-medium">Tahun Peninjauan Berikutnya</p>
                  </div>
                  <div class="col-8">
                    <p class="mb-1">: {{ $item->tahun_peninjauan_berikutnya }}</p>
                  </div>
                </div>
                <div class="row mb-1">
                  <div class="col-4">
                    <p class="mb-1 fw-medium">Jangka Waktu Kerjasama</p>
                  </div>
                  <div class="col-8">
                    <p class="mb-1 fw-medium">: {{ $item->jangka_waktu_kerjasama }}</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-12">
                <span class="fw-medium text-heading">Keterangan:</span>
                <span>{{ $item->keterangan }}</span>
              </div>
            </div>
            <hr>
            <div class="d-flex mt-3">
              <h6 class="mt-3">File Pendukung:</h6>
              <button class="btn btn-sm btn-outline-primary h-50 mt-2 ms-4" onclick="modalTambahFile()">
                <span class="text-nowrap">Tambah File</span>
              </button>
            </div>

            @if($item->File->isNotEmpty())
            <ul>
              <div class="row mt-5">
                @foreach($item->File as $file)
                <div class="col-md-2 text-centers mb-4">
                  @php
                  // Generate the correct file URL
                  $fileUrl = Storage::url($file->path);
                  $fileExists = Storage::disk('public')->exists($file->path); // Check if file exists
                  @endphp

                  @if($fileExists)
                  <!-- Display appropriate file icon with download link -->
                  @if(Str::endsWith($file->file_name, ['pdf']))
                  <a href="{{ $fileUrl }}" download="{{ $file->file_name }}">
                    <img src="{{ asset('assets/img/pdf.png') }}" alt="PDF Icon" style="width: 30px;">
                  </a>
                  @elseif(Str::endsWith($file->file_name, ['doc', 'docx']))
                  <a href="{{ $fileUrl }}" download="{{ $file->file_name }}">
                    <img src="{{ asset('assets/img/doc.png') }}" alt="DOCX Icon" style="width: 30px;">
                  </a>
                  @elseif(Str::endsWith($file->file_name, ['xls', 'xlsx']))
                  <a href="{{ $fileUrl }}" download="{{ $file->file_name }}">
                    <img src="{{ asset('assets/img/xls.png') }}" alt="Excel Icon" style="width: 30px;">
                  </a>
                  @else
                  <a href="{{ $fileUrl }}" download="{{ $file->file_name }}">
                    <img src="{{ asset('assets/img/png.png') }}" alt="File Icon" style="width: 30px;">
                  </a>
                  @endif
                  @else
                  <!-- If file does not exist, show an error message -->
                  <p class="text-danger">File not found: {{ $file->file_name }}</p>
                  @endif

                  <!-- File Name -->
                  <p class="mt-2 mb-1 small">{{ $file->file_name }}</p>
                  <p class="text-muted" style="font-size: 12px;">{{ number_format(Storage::size('public/' . $file->path)
                    / 1024, 2) }} KB</p>

                  <!-- Remove Button -->
                  <form action="{{ route('sewa.file.delete', $file->file_id) }}"
                    id="deleteFiles-form-{{ $file->file_id }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-xs btn-danger mb-2"
                      onclick="deleteFiles({{ $file->file_id }})">
                      Hapus
                    </button>
                  </form>
                </div>
                @endforeach
              </div>
            </ul>
            @endif

          </div>

        </div>
        <div class="tab-pane fade" id="navs-justified-profile" role="tabpanel">
          <div class="p-2">
            <!-- Detail Pembayaran -->
            <div class="d-flex">
              <h6 class="p-3">4. Detail Pembayaran:</h6>
              <button class="btn btn-sm btn-outline-primary btn-primary h-50 mt-2 ms-2"
                onclick="modalTambahPembayaran()">
                <span class="text-nowrap">Tambah Pembayaran</span>
              </button>
            </div>
            <div class="table-responsive">
              <table class="table table-bordered small m-0">
                <thead class="border-top">
                  <tr>
                    <th class="text-center">No.</th>
                    <th class="text-center">Tahun</th>
                    <th class="text-center">Tanggal</th>
                    <th class="text-center">Keterangan</th>
                    <th class="text-center">Nominal</th>
                    <th class="text-center">Action</th>

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
                    <td class="text-center" data-label="Nominal">Rp {{ number_format($bayar->nominal, 0, ',', '.') }}
                    </td>
                    <td class="text-center">
                      <div class="d-inline-block"><a href="javascript:;"
                          class="btn btn-sm btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow"
                          data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end m-0" style="">
                          <li>
                            <button class="dropdown-item edit-row-btn" data-id="{{ $bayar->pembayaran_id }}"
                              data-tahun="{{ $bayar->pembayaran_tahun }}"
                              data-tanggal="{{ $bayar->pembayaran_tanggal }}" data-keterangan="{{ $bayar->keterangan }}"
                              data-nominal="{{ $bayar->nominal }}">
                              Edit
                            </button>

                          </li>
                          <div class="dropdown-divider"></div>
                          <li>
                            <a href="javascript:;" class="dropdown-item text-danger delete-record"
                              onclick="deletePembayaran({{ $bayar->pembayaran_id }})">Hapus</a>
                            <form id="delete-bayar-{{ $bayar->pembayaran_id }}"
                              action="{{ route('sewa.bayar.delete', $bayar->pembayaran_id) }}" method="POST"
                              style="display: none;">
                              @method('DELETE')
                              @csrf
                            </form>
                          </li>
                        </ul>
                      </div>
                    </td>
                  </tr>
                  @php
                  $totalNominal += $bayar->nominal; // Add the current nominal to the total
                  @endphp
                  @endforeach
                  <tr>
                    <td colspan="4" class="text-center">Total</td>
                    <td class="text-center fw-bold text-primary">Rp {{ number_format($totalNominal, 0, ',', '.') }}</td>
                    <td colspan="1"></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

        </div>
        <div class="tab-pane fade" id="navs-justified-messages" role="tabpanel">
          <div class="p-2">
            <div class="d-flex">
              <h6 class="p-3">5. Detail Kenaikan:</h6>
              <button class="btn btn-sm btn-outline-primary btn-primary h-50 mt-2 ms-2" onclick="modalTambahKenaikan()">
                <span class="text-nowrap">Tambah Kenaikan</span>
              </button>
            </div>
            <div class="table-responsive">
              <table class="table table-bordered small m-0">
                <thead class="border-top">
                  <tr>
                    <th class="text-center">No.</th>
                    <th class="text-center">Tahun Ke-</th>
                    <th class="text-center">Nominal</th>
                    <th class="text-center">Action</th>
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
                    <td class="text-center">
                      <div class="d-inline-block"><a href="javascript:;"
                          class="btn btn-sm btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow"
                          data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end m-0" style="">
                          <li>
                            <button class="dropdown-item edit-row-btn-kenaikan" data-id="{{ $kenaikan->kenaikan_id }}"
                              data-nominal="{{ $kenaikan->besaran }}" data-tahun="{{ $kenaikan->tahun_ke }}"> Edit
                            </button>

                          </li>
                          <div class="dropdown-divider"></div>
                          <li>
                            <a href="javascript:;" class="dropdown-item text-danger delete-record-kenaikan"
                              onclick="deleteKenaikan({{ $kenaikan->kenaikan_id }})">Hapus</a>
                            <form id="delete-kenaikan-{{ $kenaikan->kenaikan_id }}"
                              action="{{ route('sewa.kenaikan.delete', $kenaikan->kenaikan_id) }}" method="POST"
                              style="display: none;">
                              @method('DELETE')
                              @csrf
                            </form>
                          </li>
                        </ul>
                      </div>
                    </td>
                  </tr>
                  @php
                  $totalNominal += $kenaikan->besaran; // Add the current nominal to the total
                  @endphp
                  @endforeach
                  <tr>
                    <td colspan="2" class="text-center">Total</td>
                    <td class="text-center fw-bold text-primary">Rp {{ number_format($totalNominal, 0, ',', '.') }}</td>
                    <td colspan="1"></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modalNomor" aria-modal="true" role="dialog">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="mb-2">Nomor Perjanjian</h4>
        <i>Tambah Nomor Perjanjian</i>
      </div>
      <div class="modal-body">
        <hr>
        <form action="{{ route('sewa.nomor.tambah', $item->transaksi_id)}}" id="nomorForm" method="POST"
          enctype="multipart/form-data">
          @csrf
          <div class="row mt-2">
            <div class="col-lg-12 col-sm-6">
              <div class="form-floating form-floating-outline mb-3">
                <input type="text" class="form-control" id="nomor_perjanjian" name="nomor_perjanjian"
                  placeholder="Input Nomor Perjanjian" />
                <label for="nomor_perjanjian">Nomor Perjanjian</label>
              </div>
            </div>
            <div class="col-lg-12 col-sm-6">
              <div class="form-floating form-floating-outline mb-3 mt-2">
                <input type="date" class="form-control" id="tanggal_perjanjian" name="tanggal_perjanjian"
                  placeholder="Input Tanggal Perjanjian" />
                <label for="tanggal_perjanjian">Tanggal Perjanjian</label>
              </div>
            </div>
            <div class="col-12 d-flex flex-wrap justify-content-center gap-4 row-gap-4 mt-4">
              <button type="reset" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="modal"
                aria-label="Close">
                Back
              </button>
              <button type="submit" class="btn btn-primary waves-effect waves-light">
                Tambah
              </button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
</div>

<div class="modal fade" id="editModalKenaikan" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="editFormKenaikan" method="POST" action="{{ route('sewa.kenaikan.update') }}">
        @csrf
        <input type="hidden" name="kenaikan_id" id="kenaikan_id">
        <div class="modal-header">
          <h5 class="modal-title">Edit Kenaikan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row mb-2">
            <div class="col-lg-6 col-sm-6">
              <label for="tahun_ke" class="form-label">Tahun Ke-</label>
              <input type="text" class="form-control" id="tahun_ke" name="tahun_ke">
            </div>
            <div class="col-lg-6 col-sm-6">
              <label for="besaran" class="form-label">Nominal</label>
              <input type="text" oninput="formatRupiah(this)" onkeydown="allowOnlyNumbers(event)" class="form-control"
                id="besaran" name="besaran">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update Data</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-dialog-centered">
    <div class="modal-content">
      <form id="editForm" method="POST" action="{{ route('sewa.bayar.update') }}">
        @csrf
        <input type="hidden" name="pembayaran_id" id="pembayaran_id">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit Pembayaran</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row mb-2">
            <div class="col-lg-6 col-sm-6">
              <label for="pembayaran_tahun" class="form-label">Tahun</label>
              <input type="text" class="form-control" id="pembayaran_tahun" name="pembayaran_tahun">
            </div>
            <div class="col-lg-6 col-sm-6">
              <label for="pembayaran_tanggal" class="form-label">Tanggal</label>
              <input type="date" class="form-control" id="pembayaran_tanggal" name="pembayaran_tanggal">
            </div>
          </div>
          <div class="mb-2">
            <label for="keterangan" class="form-label">Keterangan</label>
            <input type="text" class="form-control" id="keterangan" name="keterangan">
          </div>
          <div class="mb-2">
            <label for="nominal" class="form-label">Nominal</label>
            <input type="text" oninput="formatRupiah(this)" onkeydown="allowOnlyNumbers(event)" class="form-control"
              id="nominal" name="nominal">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update Data</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modalFile" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form id="fileForm" method="POST" action="{{ route('sewa.file.tambah') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="transaksi_id" id="transaksi_id" value="{{ $item->transaksi_id }}">
        <div class="p-3">
          <p class="mb-3">Tambah File Bisa Lebih Dari 1</p>

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

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Tambah File</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modalTambahBayar" aria-modal="true" role="dialog">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="mb-2">Pembayaran</h4>
        <i>Tambah Pembayaran</i>
      </div>
      <div class="modal-body">
        <hr>
        <form action="{{ route('sewa.bayar', $item->transaksi_id)}}" id="pembayaranForm" method="POST"
          enctype="multipart/form-data">
          @csrf
          <div class="row mt-2">
            <div class="col-lg-6 col-sm-6">
              <div class="form-floating form-floating-outline mb-3">
                <input type="text" class="form-control" id="pembayaran_tahun" name="pembayaran_tahun"
                  placeholder="Input Tahun Pembayaran" />
                <label for="pembayaran_tahun">Tahun<span style="color: red">*</span></label>
              </div>
            </div>
            <div class="col-lg-6 col-sm-6">
              <div class="form-floating form-floating-outline mb-3">
                <input type="date" class="form-control" id="pembayaran_tanggal" name="pembayaran_tanggal"
                  placeholder="Tanggal Perjanjian Sewa" />
                <label for="pembayaran_tanggal">Pembayaran Tanggal <span style="color: red">*</span></label>
              </div>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-lg-12 col-sm-6">
              <div class="input-group input-group-merge">
                <span class="input-group-text">Rp.</span>
                <div class="form-floating form-floating-outline">
                  <input type="text" oninput="formatRupiah(this)" onkeydown="allowOnlyNumbers(event)"
                    class="form-control" placeholder="Input Nominal" id="nominal" name="nominal" />
                  <label>Nominal <span style="color: red">*</span></label>
                </div>
              </div>
            </div>
          </div>
          <div class="row mt-4">
            <div class="col-lg-12 col-sm-6">
              <div class="form-floating form-floating-outline mb-3">
                <input type="text" class="form-control" id="keterangan" name="keterangan"
                  placeholder="Input Keterangan" />
                <label for="keterangan">Keterangan<span style="color: red">*</span></label>
              </div>
            </div>
          </div>
          <div class="col-12 d-flex flex-wrap justify-content-center gap-4 row-gap-4 mt-4">
            <button type="reset" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="modal"
              aria-label="Close">
              Back
            </button>
            <button type="submit" class="btn btn-primary waves-effect waves-light">
              Tambah
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalTambahKenaikan" aria-modal="true" role="dialog">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="mb-2">Kenaikan</h4>
        <i>Tambah Kenaikan</i>
      </div>
      <div class="modal-body">
        <hr>
        <form action="{{ route('sewa.kenaikan.tambah', $item->transaksi_id)}}" id="kenaikanForm" method="POST"
          enctype="multipart/form-data">
          @csrf
          <div class="row mt-2">
            <div class="col-lg-12 col-sm-6">
              <div class="form-floating form-floating-outline mb-3">
                <input type="text" class="form-control" id="tahun_ke" name="tahun_ke" placeholder="Input Tahun Ke-" />
                <label for="tahun_ke">Tahun Ke<span style="color: red">*</span></label>
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-lg-12 col-sm-6">
                <div class="input-group input-group-merge">
                  <span class="input-group-text">Rp.</span>
                  <div class="form-floating form-floating-outline">
                    <input type="text" oninput="formatRupiah(this)" onkeydown="allowOnlyNumbers(event)"
                      class="form-control" placeholder="Input Nominal" id="besaran" name="besaran" />
                    <label>Nominal <span style="color: red">*</span></label>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 d-flex flex-wrap justify-content-center gap-4 row-gap-4 mt-4">
              <button type="reset" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="modal"
                aria-label="Close">
                Back
              </button>
              <button type="submit" class="btn btn-primary waves-effect waves-light">
                Tambah
              </button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
<div class="modal fade" id="editNomor" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="editFormNomor" method="POST" action="{{ route('sewa.nomor.update') }}">
        @csrf
        <input type="hidden" name="transaksi_nomor_id" id="transaksi_nomor_id">
        <div class="modal-header">
          <h5 class="modal-title">Edit Nomor Perjanjian</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row mb-2">
            <div class="col-lg-12 col-sm-12">
              <label for="nomor_perjanjian" class="form-label">Nomor Perjanjian</label>
              <input type="text" class="form-control" id="nomor_perjanjian_m" name="nomor_perjanjian_m">
            </div>
            <div class="col-lg-12 col-sm-12">
              <label for="tanggal_perjanjian" class="form-label">Tanggal</label>
              <input type="date" class="form-control" id="tanggal_perjanjian_m" name="tanggal_perjanjian_m">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update Data</button>
        </div>
      </form>
    </div>
  </div>
</div>
</div>



<style>
  .text-centers {
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  /* Dropzone container styling */
  #dropzoneArea {
    border: 2px dashed #ccc;
    padding: 150px;
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
  document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.edit-row-btn').forEach(button => {
      button.addEventListener('click', function () {
        const modal = new bootstrap.Modal(document.getElementById('editModal'));

        document.getElementById('pembayaran_id').value = this.dataset.id;
        document.getElementById('pembayaran_tahun').value = this.dataset.tahun;
        document.getElementById('pembayaran_tanggal').value = this.dataset.tanggal;
        document.getElementById('keterangan').value = this.dataset.keterangan;
        document.getElementById('nominal').value = this.dataset.nominal;

        modal.show();
      });
    });

    document.querySelectorAll('.edit-row-btn-nomor').forEach(button => {
      button.addEventListener('click', function () {
        const modal = new bootstrap.Modal(document.getElementById('editNomor'));

        document.getElementById('transaksi_nomor_id').value = this.dataset.id;
        document.getElementById('nomor_perjanjian_m').value = this.dataset.nomor;
        document.getElementById('tanggal_perjanjian_m').value = this.dataset.tanggal;
        modal.show();
      });
    });

    document.querySelectorAll('.edit-row-btn-kenaikan').forEach(button2 => {
      console.log(`MASOK`)
      button2.addEventListener('click', function () {
        const modal2 = new bootstrap.Modal(document.getElementById('editModalKenaikan'));

        document.getElementById('kenaikan_id').value = this.dataset.id;
        document.getElementById('tahun_ke').value = this.dataset.tahun;
        document.getElementById('besaran').value = this.dataset.nominal;
        modal2.show();
      });
    });
  });

  function deleteNomor(nomorId) {
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        // Prevent default behavior and submit the delete form
        event.preventDefault();
        document.getElementById(`delete-nomor-${nomorId}`).submit();
      }
    });
  }

  function deleteFiles(fileId) {
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        // Prevent default behavior and submit the delete form
        event.preventDefault();
        document.getElementById(`deleteFiles-form-${fileId}`).submit();
      }
    });
  }

  function deletePembayaran(itemId) {
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        // Prevent default behavior and submit the delete form
        event.preventDefault();
        document.getElementById(`delete-bayar-${itemId}`).submit();
      }
    });
  }

  function deleteKenaikan(itemId) {
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        // Prevent default behavior and submit the delete form
        event.preventDefault();
        document.getElementById(`delete-kenaikan-${itemId}`).submit();
      }
    });
  }

  function deleteSewa(itemId) {
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        // Prevent default behavior and submit the delete form
        event.preventDefault();
        document.getElementById(`delete-sewa-${itemId}`).submit();
      }
    });
  }

  function selesaiSewa(itemId) {
    Swal.fire({
      title: 'Selesai Sewa',
      text: "Apakah dokumen ini sudah selesai sewa?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya! Selesai'
    }).then((result) => {
      if (result.isConfirmed) {
        // Prevent default behavior and submit the delete form
        event.preventDefault();
        document.getElementById(`selesai-sewa-${itemId}`).submit();
      }
    });
  }


  function modalTambahPembayaran() {
    $('#modalTambahBayar').modal('show')
  }

  function modalTambahKenaikan() {
    $('#modalTambahKenaikan').modal('show')
  }

  function modalTambahFile() {
    $('#modalFile').modal('show')
  }

  function modalTambahNomor() {
    $('#modalNomor').modal('show')
  }

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

</script>
@endsection