@php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
@endphp
@php
$configData = Helper::appClasses();
@endphp
@extends('layouts/layoutMaster')

@section('title', 'Dashboard')
@section('vendor-style')
{{--
<link rel="stylesheet" href="{{asset('assets/vendor/libs/swiper/swiper.scss')}}" /> --}}
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/animate-css/animate.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}" />
<link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
@endsection

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
<div class="card">
  <div class="d-flex align-items-end row">
    <div class="col-md-6 order-2 order-md-1">
      <div class="card-body">
        <h4 class="card-title mb-4">Selamat Datang, <span class="fw-bold">{{ Auth::user()->name }}!</span> 👋</h4>
        <p class="mb-0"><b>Website Pencatatan Sewa, </b>silahkan klik Tambah Sewa</p>
        <p>Anda dapat melakukan pencatatan pada website ini.</p>
      </div>
    </div>
    <div class="col-md-6 text-center text-md-end order-1 order-md-2">
      <div class="card-body ">
        <button onclick="modalTambah()" class=" btn btn-primary waves-effect waves-light">Tambah
          Sewa</button>
      </div>
    </div>
  </div>
</div>
<div class="card mt-3">
  <div class="card-header p-0">
    {{-- <div class="card-datatable">
      <table class="datatables-ajax table table-bordered text-nowrap small" id="tableData"> --}}
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
                <td class="text-center">{{ $loop->iteration }}.</td>
                <td class="text-center">{{ $item->Jenis->jenis_nama }}</td>
                <td class="text-center">{{ $item->tanggal_perjanjian }}</td>
                <td class="text-center">{{ $item->kabupaten }}</td>
                <td class="text-center">{{ $item->nama_pengguna }}</td>
                <td class="text-center">{{ $item->sistem_pembayaran }}</td>
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
                          action="{{ route('sewa.destroy', $item->transaksi_id) }}" method="POST"
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

  <div class="modal fade" id="modalDetail" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-simple modal-enable-otp modal-dialog-centered">
      <div class="modal-content">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="modal-header">
          <h5 class="modal-title" id="modalDetailLabel">Detail Transaksi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div id="modal-body-content">
            <!-- Dynamic content will be inserted here via AJAX -->
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalTambah" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-simple modal-enable-otp modal-dialog-centered">
      <div class="modal-content">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="modal-body p-0">
          <div class="text-center mb-2">
            <h4 class="mb-2">Pilih Jenis Sewa</h4>
            <i>Jenis Sewa, Klik selanjutnya untuk melanjutkan</i>
          </div>
          <form id="jenisForm" class="row g-5 mt-3">
            <div class="col-12 col-md-12 mt-4">
              <div class="form-floating form-floating-outline">
                <select id="jenis_id" name="jenis" class="select2 form-select form-select-lg" data-allow-clear="true">
                  <option value="">Pilih Jenis Sewa</option> <!-- Default option without value -->
                  @foreach ($jenis as $item)
                  <option value="{{ $item->jenis_id }}">{{ $item->jenis_nama ?? '' }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-12 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
              <button type="reset" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="modal"
                aria-label="Close">
                Back
              </button>
              <button type="button" class="btn btn-primary waves-effect waves-light" id="btnSelanjutnya">
                Selanjutnya
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>


  {{-- <div class="modal fade" id="fullscreenModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="nav-align-top">
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item">
                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                  data-bs-target="#navs-top-home" aria-controls="navs-top-home" aria-selected="true">Data
                  Penyewaan</button>
              </li>
              <li class="nav-item">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                  data-bs-target="#navs-top-profile" aria-controls="navs-top-profile"
                  aria-selected="false">Pembayaran</button>
              </li>
              <li class="nav-item">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                  data-bs-target="#navs-top-messages" aria-controls="navs-top-messages" aria-selected="false">File
                  Pendukung</button>
              </li>
            </ul>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <div class="tab-content p-0">
            <div class="tab-pane fade show active" id="navs-top-home" role="tabpanel">








            </div>
            <div class="tab-pane fade" id="navs-top-profile" role="tabpanel">
              <p>
                Donut dragée jelly pie halvah. Danish gingerbread bonbon cookie wafer candy oat cake ice cream. Gummies
                halvah
                tootsie roll muffin biscuit icing dessert gingerbread. Pastry ice cream cheesecake fruitcake.
              </p>
              <p class="mb-0">
                Jelly-o jelly beans icing pastry cake cake lemon drops. Muffin muffin pie tiramisu halvah cotton candy
                liquorice caramels.
              </p>
            </div>
            <div class="tab-pane fade" id="navs-top-messages" role="tabpanel">
              <p>
                Oat cake chupa chups dragée donut toffee. Sweet cotton candy jelly beans macaroon gummies cupcake gummi
                bears
                cake chocolate.
              </p>
              <p class="mb-0">
                Cake chocolate bar cotton candy apple pie tootsie roll ice cream apple pie brownie cake. Sweet roll
                icing
                sesame snaps caramels danish toffee. Brownie biscuit dessert dessert. Pudding jelly jelly-o tart brownie
                jelly.
              </p>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div> --}}
  <style>
    .bg-yellow {
      background-color: yellow;
    }

    .bg-red {
      background-color: red;
    }

    .bg-purple {
      background-color: purple;
      color: white;
      /* Ensure text is readable */
    }

    .bg-blue {
      background-color: lightblue;
    }

    .bg-grey {
      background-color: grey;
      color: white;
      /* Ensure text is readable */
    }

    .bg-orange {
      background-color: orange;
    }
  </style>

  <script src="{{asset('assets/vendor/libs/jquery/jquery.js')}}"></script>

  <script>
    document.getElementById('btnSelanjutnya').addEventListener('click', function () {
    const selectedValue = document.getElementById('jenis_id').value;
    if (selectedValue) {
      window.location.href = `/sewa/create?jenis=${encodeURIComponent(selectedValue)}`;
    } else {
      alert('Pilih jenis sewa sebelum melanjutkan!');
    }
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

  function modalTambah() {
    $('#modalTambah').modal('show')
  }
  $(document).ready(function () {
    var table = $('#tableData').DataTable();
    $('.open-modal').on('click', function () {
      var transaksi_id = $(this).data('id');
      console.log(transaksi_id)

      $.ajax({
            url: '/sewa/' + transaksi_id,  // This will hit the show method
            type: 'GET',
            success: function(response) {
                console.log(response)
                $('#fullscreenModal').modal('show');  // Open the modal
            },
            error: function(xhr, status, error) {
                alert("An error occurred while fetching data.");
            }
        });
    });
  });

  </script>
  @endsection
