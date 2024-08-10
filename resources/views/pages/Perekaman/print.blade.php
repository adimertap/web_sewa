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

<div class="row invoice-preview">
  <!-- Invoice -->
  <div class="p-sm-10 p-3">

    <div
      class="d-flex justify-content-between flex-xl-row flex-md-column flex-sm-row flex-column text-heading align-items-xl-center align-items-md-start align-items-sm-center flex-wrap gap-6">
      <div>
        <div class="d-flex svg-illustration align-items-center gap-2 mb-6">
          {{-- <span
            class="app-brand-logo demo">@include('_partials.macros',["width"=>25,"withbg"=>'var(--bs-primary)'])</span>
          --}}
          <span class="mb-0 app-brand-text fw-semibold demo">Perekaman Barang {{ $tr->jenis_transaksi
            }}</span>
        </div>
        <p class="mb-1">Lakukan Pengecekan</p>
        <p class="mb-1">Terhadap Perekaman Barang Ini</p>
      </div>
      <div>
        <h5 class="mb-6">#{{ $tr->transaksi_code }}</h5>
        <div class="mb-1">
          <span>Date:</span>
          <span>{{ \Carbon\Carbon::parse($tr->transaksi_date)->format('d F Y') }}</span>
        </div>
        {{-- <div>
          <span>Status:</span>
          <i>{{ $tr->transaksi_status }}</i>
        </div> --}}
      </div>
    </div>
    <hr>
    <div class="table-responsive border rounded-4 border-bottom-0">
      <table class="table m-0">
        <thead>
          <tr>
            <th>Kode</th>
            <th>Barang</th>
            <th>Qty</th>
            <th>Satuan</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($tr->Detail as $item)
          <tr>
            <td class="text-nowrap text-heading small">{{ $item->Barang->barang_code }}</td>
            <td class="text-nowrap small">{{ $item->Barang->barang_name }}</td>
            <td class="small">{{ $item->qty }}</td>
            <td class="small">{{ $item->Barang->satuan }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <hr class="mt-0 mb-6">
    <div class="card-body p-0">
      <div class="row">
        <div class="col-12">
          <span class="fw-medium text-heading">Note:</span>
          @if($tr->transaksi_status == 'Pending')
          <span>Mohon untuk dilakukan konfirmasi pada dokumen ini, agar stok dapat terupdate dan stok
            opname terus berjalan </span>
          @elseif ($tr->transaksi_status == 'Selesai')
          <span>Perekaman barang telah di selesai diproses!
            Terima Kasih. </span>
          @endif
        </div>
      </div>
    </div>
  </div>
  <!-- /Invoice -->
</div>
<script src="{{asset('assets/vendor/libs/jquery/jquery.js')}}"></script>
<script>
  window.onload = function() {
        window.print();
    }
</script>



@endsection