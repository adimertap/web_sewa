@php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
@endphp
@php
$configData = Helper::appClasses();
@endphp
{{-- @extends('layouts/layoutMaster') --}}
@extends('layouts.blankLayout')


@section('title', 'Dashboard')
@section('vendor-style')
{{--
<link rel="stylesheet" href="{{asset('assets/vendor/libs/swiper/swiper.scss')}}" /> --}}
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/animate-css/animate.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}" />
<link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">

@endsection

{{-- @section('page-style')
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/cards-statistics.scss')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/cards-analytics.scss')}}">
@endsection --}}

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
<script src="{{asset('assets/vendor/libs/swiper/swiper.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
<script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/dashboards-analytics.js')}}"></script>
<script src="{{asset('assets/js/extended-ui-sweetalert2.js')}}"></script>
<script src="{{asset('assets/js/ui-modals.js')}}"></script>

@endsection

@section('content')
@include('sweetalert::alert')
<div class="p-4">
  <div class="d-flex justify-content-between">
    <div>
      <a href="{{ route('dashboard') }}" type="button"
        class="btn btn-outline-secondary waves-effect waves-light cursor-pointer">
        Kembali ke Home
      </a>
      <button type="button" onclick="Download()"
        class="btn btn-outline-primary waves-effect waves-light cursor-pointer">
        Download dan Filter Laporan
      </button>
    </div>
    <h4>Laporan Sewa</h4>
  </div>
  <hr class="mt-4">
  <form method="GET" action="{{ route('laporan-sewa.index') }}">
    <div class="row mt-4">
      <div class="col-2">
        <select id="jenis_id" name="jenis" class="select2 form-select form-select-sm" data-allow-clear="true">
          <option value="">Jenis Sewa</option>
          @foreach ($jenis as $item)
          <option value="{{ $item->jenis_id }}" {{ request('jenis')==$item->jenis_id ? 'selected' : '' }}>
            {{ $item->jenis_nama ?? '' }}
          </option>
          @endforeach
        </select>
      </div>
      <div class="col-2">
        <select id="kabupaten" name="kabupaten" class="select2 form-select form-select-sm" data-allow-clear="true">
          <option value="">Kabupaten/Kota</option>
          @foreach ($kab as $kb)
          <option value="{{ $kb }}" {{ request('kabupaten')==$kb ? 'selected' : '' }}>{{ $kb }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-2">
        <select id="sistem_pembayaran" name="sistem_pembayaran" class="select2 form-select form-select-sm"
          data-allow-clear="true">
          <option value="">Sistem Pembayaran</option> <!-- Default option without value -->
          @foreach ($sbayar as $item)
          <option value="{{ $item->sistem_id }}">{{ $item->sistem_pembayaran ?? '' }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-2">
        <select id="lokasi" name="lokasi" class="select2 form-select form-select-sm" data-allow-clear="true">
          <option value="">Lokasi</option>
          @foreach ($lokasi as $ls)
          <option value="{{ $ls }}" {{ request('lokasi')==$ls ? 'selected' : '' }}>{{ $ls }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-2">
        <select id="jangka_waktu" name="jangka_waktu" class="select2 form-select form-select-sm"
          data-allow-clear="true">
          <option value="">Jangka Waktu Kerjasama</option>
          @foreach ($waktuSewa as $ws)
          <option value="{{ $ws }}" {{ request('jangka_waktu')==$ws ? 'selected' : '' }}>{{ $ws }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-2">
        <button type="submit" class="btn btn-outline-primary waves-effect waves-light cursor-pointer">
          Filter
        </button>
        <a href="{{ route('laporan-sewa.index') }}"
          class="btn btn-outline-danger waves-effect waves-light cursor-pointer">
          Reset
        </a>
      </div>
    </div>
  </form>


  <div class="card mt-3">
    <div class="card-header p-0">
      <div class="card-datatable text-nowrap">
        <table class="dt-scrollableTable table table-bordered small" id="tableData">
          <thead>
            <tr>
              <th>No.</th>
              <th class="text-center">Jenis</th>
              <th class="text-center">Tanggal</th>
              <th class="text-center">Kab/Kota</th>
              <th class="text-center">Nama</th>
              <th class="text-center">Pembayaran</th>
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody class="list">
            @foreach ($datas as $item)
            <tr role="row" class="odd ">
              <td class="text-center">{{ $loop->iteration + $datas->firstItem() - 1 }}.</td>
              <td class="text-center">{{ $item->Jenis->jenis_nama }}</td>
              <td class="text-center">{{ isset($item->Nomor[0]) ? $item->Nomor[0]->tanggal_perjanjian : '-' }}</td>
              <td class="text-center">{{ $item->kabupaten }}</td>
              <td class="text-center">{{ $item->nama_pengguna }}</td>
              <td class="text-center">{{ $item->SistemBayar->sistem_pembayaran ?? '-' }}</td>
              <td class="text-center">
                <a href="{{ route('sewa.show', $item->transaksi_id) }}"
                  class="btn btn-sm  btn-text-primary rounded-pill waves-effect">
                  <i class="ri-eye-line ri-20px"></i>
                </a>
                <div class="d-inline-block">
                  <a href="javascript:;"
                    class="btn btn-sm btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow"
                    data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end m-0" style="">
                    <li><a href="{{ route('sewa.edit', $item->transaksi_id) }}" class="dropdown-item">Edit</a></li>
                    <li><a href="{{ route('sewa.print', $item->transaksi_id) }}" target="_blank"
                        class="dropdown-item">Cetak</a></li>
                    <div class="dropdown-divider"></div>
                    <li>
                      <a href="javascript:;" class="dropdown-item text-danger delete-record"
                        onclick="deleteFunction({{ $item->transaksi_id }})">Delete</a>
                      <form id="delete-form-{{ $item->transaksi_id }}"
                        action="{{ route('sewa.destroy', $item->transaksi_id) }}" method="POST" style="display: none;">
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
    <div class="card-footer">
      <div class="d-flex justify-content-between">
        <p>Showing {{ $datas->firstItem() }} to {{ $datas->lastItem() }} of {{ $datas->total() }} entries</p>
        {{ $datas->links('pagination::bootstrap-4') }}
      </div>
    </div>
  </div>

</div>


<div class="modal fade" id="modalDownload" aria-modal="true" role="dialog">
  <div class="modal-dialog modal-simple modal-enable-otp modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <form action="{{ route('laporan-sewa.excel')}}" id="excelForm" method="POST" enctype="multipart/form-data">
          @csrf
          <div id="modal-body-content">
            <div class="row mt-2">
              <p>Filter dan Download</p>
              <div class="col-12">
                <select id="jenis_id" name="jenis" class="select2 form-select form-select-lg" data-allow-clear="true">
                  <option value="">Jenis Sewa</option>
                  @foreach ($jenis as $item)
                  <option value="{{ $item->jenis_id }}" {{ request('jenis')==$item->jenis_id ? 'selected' : '' }}>
                    {{ $item->jenis_nama ?? '' }}
                  </option>
                  @endforeach
                </select>
              </div>
              <div class="col-12 mt-2">
                <select id="kabupaten" name="kabupaten" class="select2 form-select form-select-lg"
                  data-allow-clear="true">
                  <option value="">Kabupaten/Kota</option>
                  @foreach ($kab as $kb)
                  <option value="{{ $kb }}" {{ request('kabupaten')==$kb ? 'selected' : '' }}>{{ $kb }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-12 mt-2">
                <select id="sistem_pembayaran" name="sistem_pembayaran" class="select2 form-select form-select-lg"
                  data-allow-clear="true">
                  <option value="">Sistem Pembayaran</option> <!-- Default option without value -->
                  @foreach ($sbayar as $item)
                  <option value="{{ $item->sistem_id }}">{{ $item->sistem_pembayaran ?? '' }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-12 mt-2">
                <select id="lokasi" name="lokasi" class="select2 form-select form-select-lg" data-allow-clear="true">
                  <option value="">Lokasi</option>
                  @foreach ($lokasi as $ls)
                  <option value="{{ $ls }}" {{ request('lokasi')==$ls ? 'selected' : '' }}>{{ $ls }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-12 mt-2">
                <select id="jangka_waktu" name="jangka_waktu" class="select2 form-select form-select-lg"
                  data-allow-clear="true">
                  <option value="">Jangka Waktu Kerjasama</option>
                  @foreach ($waktuSewa as $ws)
                  <option value="{{ $ws }}" {{ request('jangka_waktu')==$ws ? 'selected' : '' }}>{{ $ws }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-12 mt-2">
                <select id="tahun" name="tahun" class="select2 form-select form-select-lg" data-allow-clear="true">
                  <option value="">Pembayaran Tahun</option>
                  @foreach (array_reverse(range(2010, now()->year)) as $year)
                  <option value="{{ $year }}">{{ $year }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-12 d-flex flex-wrap justify-content-center gap-4 row-gap-4 mt-4">
              <button type="reset" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="modal"
                aria-label="Close">
                Back
              </button>
              <button type="submit" class="btn btn-primary waves-effect waves-light">
                Download
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>



<script src="{{asset('assets/vendor/libs/jquery/jquery.js')}}"></script>

<script>
  $(document).ready(function() {
    $('#tableData').DataTable({
        paging: false, // Disable DataTables pagination
        searching: true, // Disable search box
        ordering: true, // Disable column ordering
        info: false, // Disable table info ("Showing X of Y entries")
        scrollX: true // Enable horizontal scrolling if needed
    });
});


  function deleteFunction(itemId) {
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
        document.getElementById(`delete-form-${itemId}`).submit();
      }
    });
  }

  function Download() {
    $('#modalDownload').modal('show')
  }
  $(document).ready(function () {

  });

</script>
@endsection