@extends('layouts/layoutMaster')

@section('title', 'Saran dan Masukan')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/animate-css/animate.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}" />
<link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">

@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
<script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/extended-ui-sweetalert2.js')}}"></script>
@endsection

@section('content')
<style>
  table td {
    word-wrap: break-word;
    white-space: normal;
    max-width: 150px;
    /* Adjust according to your layout */
    overflow: hidden;
    text-overflow: ellipsis;
  }
</style>
@include('sweetalert::alert')


<div class="card">
  <div class="card-header p-3">
    <p>Saran dan Masukan User</p>
  </div>
  <div class="card-datatable">
    <table class="datatables-ajax table table-bordered small" id="tableData">
      <thead>
        <tr>
          <th style="width: 5px">No.</th>
          <th class="text-center" style="width: 30px">Seksi</th>
          <th class="text-center" style="width: 40px">User</th>
          <th class="text-center" style="width: 20px">Tanggal</th>
          <th class="text-center">Saran</th>
        </tr>
      </thead>
      <tbody class="list">
        @foreach ($saran as $item)
        <tr role="row" class="odd">
          <th scope="row" class="text-center">{{ $loop->iteration }}.</th>
          <th scope="row" class="text-center small">{{ $item->Seksi->seksi_name }}</th>
          <th scope="row" class="text-center small">{{ $item->User->name }}</th>
          <th scope="row" class="text-center small">{{ $item->created_at->format('j F Y') }}</th>
          <th scope="row" class="small">{{ $item->saran }}</th>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

</div>

<script src="{{asset('assets/vendor/libs/jquery/jquery.js')}}"></script>
<script>
  $(document).ready(function () {
        var table = $('#tableData').DataTable();
    });
</script>



@endsection