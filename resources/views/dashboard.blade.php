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
<link rel="stylesheet" href="{{asset('assets/vendor/libs/swiper/swiper.scss')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/animate-css/animate.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}" />
<link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">

@endsection

@section('page-style')
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/cards-statistics.scss')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/cards-analytics.scss')}}">
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
@endsection

@section('content')
<div class="card">
  <div class="d-flex align-items-end row">
    <div class="col-md-6 order-2 order-md-1">
      <div class="card-body">
        <h4 class="card-title mb-4">Welcome, <span class="fw-bold">{{ Auth::user()->name }}!</span> 👋</h4>
        @if(Auth::user()->role == 'User')
        <p class="mb-0"><b>Website bon barang, </b>silahkan klik Tambah Bon Barang</p>
        <p>Anda dapat melakukan bon barang pada website ini.</p>
        <a href="{{ route('transaksi.create') }}" class="mt-3 btn btn-primary waves-effect waves-light">Tambah
          Bon
          Barang</a>
        @else
        <p class="mb-0"><b>Website bon barang, </b>silahkan klik Tambah Rekam Barang</p>
        <p>Anda dapat melakukan perekaman barang pada website ini.</p>
        @if(Auth::user()->role !== "Admin")
        {{-- <a href="{{ route('perekaman.create') }}" class="mt-3 btn btn-primary waves-effect waves-light">Rekam
          Barang</a> --}}
        @endif

        @endif

      </div>
    </div>
    <div class="col-md-6 text-center text-md-end order-1 order-md-2">
      <div class="card-body pb-0 px-0 pt-2">
        <img src="../../assets/img/illustrations/illustration-john-light.png" height="186" class="scaleX-n1-rtl"
          alt="View Profile" data-app-light-img="illustrations/illustration-john-light.png"
          data-app-dark-img="illustrations/illustration-john-dark.png">
      </div>
    </div>
  </div>
</div>
<div class="row mt-4">
  <div class="col-sm-6 col-lg-3">
    <div class="card card-border-shadow-primary h-100">
      <div class="card-body">
        <div class="d-flex align-items-center mb-2">
          <div class="avatar me-4">
            <span class="avatar-initial rounded-3 bg-label-primary"><i class="ri-time-line ri-24px"></i></span>
          </div>
          <h4 class="mb-0">{{ $pendingCount }}</h4>
        </div>
        <h6 class="mb-0 fw-normal">Pending</h6>
        <p class="mb-0">
          <span class="me-1 fw-medium">.</span>
          <small class="text-muted">Pending Status</small>
        </p>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-lg-3">
    <div class="card card-border-shadow-warning h-100">
      <div class="card-body">
        <div class="d-flex align-items-center mb-2">
          <div class="avatar me-4">
            <span class="avatar-initial rounded-3 bg-label-warning"><i class="ri-check-line ri-24px"></i></span>
          </div>
          <h4 class="mb-0">{{ $approveCount }}</h4>
        </div>
        <h6 class="mb-0 fw-normal">Approved</h6>
        <p class="mb-0">
          <span class="me-1 fw-medium">.</span>
          <small class="text-muted">Approved Status</small>
        </p>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-lg-3">
    <div class="card card-border-shadow-danger h-100">
      <div class="card-body">
        <div class="d-flex align-items-center mb-2">
          <div class="avatar me-4">
            <span class="avatar-initial rounded-3 bg-label-danger"><i class="ri-error-warning-line ri-24px"></i></span>
          </div>
          <h4 class="mb-0">{{ $rejectCount }}</h4>
        </div>
        <h6 class="mb-0 fw-normal">Reject</h6>
        <p class="mb-0">
          <span class="me-1 fw-medium">.</span>
          <small class="text-muted">Reject Status</small>
        </p>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-lg-3">
    <div class="card card-border-shadow-success h-100">
      <div class="card-body">
        <div class="d-flex align-items-center mb-2">
          <div class="avatar me-4">
            <span class="avatar-initial rounded-3 bg-label-success"><i class="ri-check-line ri-24px"></i></span>
          </div>
          <h4 class="mb-0">{{ $selesaiCount }}</h4>
        </div>
        <h6 class="mb-0 fw-normal">Selesai</h6>
        <p class="mb-0">
          <span class="me-1 fw-medium">.</span>
          <small class="text-muted">Selesai Status</small>
        </p>
      </div>
    </div>
  </div>
</div>
<div class="row ps-3 pe-3 mt-4 pb-3">
  <div class="card p-0 pb-3">
    <div class="card-header p-0 ps-4 pt-3 text-md-start text-center">
      <div class="d-flex justify-content-between">
        @if(Auth::user()->role == 'Admin')
        <h5>Outstanding Approval</h5>
        @else
        <h5>Pending / Reject</h5>

        @endif
        {{-- <button type="button" id="btn-tambah" data-bs-toggle="modal" data-bs-target="#modalTambah"
          class="btn btn-primary waves-effect waves-light">Tambah</button> --}}
      </div>

    </div>
    <div class="card-datatable text-nowrap small p-0">
      <table class="datatables-ajax table table-bordered" id="tableData">
        <thead>
          <tr>
            <th>No.</th>
            @if(Auth::user()->role == 'Admin')
            <th class="text-center">User</th>
            <th class="text-center">Seksi</th>
            @endif
            <th class="text-center">Kode</th>
            <th class="text-center" style="max-width: 25px!important">Tanggal</th>
            <th class="text-center" style="max-width: 25px!important">Total</th>
            <th class="text-center" style="max-width: 30px!important">Status</th>
          </tr>
        </thead>
        <tbody class="list">
          @foreach ($tr as $item)
          <tr role="row" class="odd ">
            <th scope="row" class="text-center">{{ $loop->iteration }}.</th>
            @if(Auth::user()->role == 'Admin')
            <td class="text-center">{{ $item->User->name ?? '' }}</td>
            <td class="text-center">{{ $item->User->Seksi->seksi_name ?? '' }}</td>
            @endif
            <td class="text-center">
              <a href="{{ route('transaksi.show', $item->transaksi_id) }}" class="text-primary "><u>{{
                  $item->transaksi_code }}</u> </a>

            </td>
            <td class="text-center">{{ \Carbon\Carbon::parse($item->transaksi_date)->format('d F Y') }}</td>
            <td class="text-center">{{ $item->total_qty ?? 0 }}</td>
            <td class="text-center">
              @if($item->transaksi_status == "Pending")
              <span class="badge rounded-pill  bg-label-primary">Pending</span>
              @elseif($item->transaksi_status == 'Approved')
              <span class="badge rounded-pill  bg-label-success">Approved</span>
              @elseif($item->transaksi_status == 'Reject')
              <span class="badge rounded-pill  bg-label-danger">Reject</span>
              @elseif($item->transaksi_status == 'Selesai')
              <span class="badge rounded-pill  bg-label-success">Done</span>
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
<script src="{{asset('assets/vendor/libs/jquery/jquery.js')}}"></script>

<script>
  $(document).ready(function () {
        var table = $('#tableData').DataTable();

    });
</script>
@endsection