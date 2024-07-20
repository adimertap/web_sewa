@extends('layouts/layoutMaster')

@section('title', 'Detail Laporan Bulanan')

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
@include('sweetalert::alert')

<div class="d-flex justify-content-between">
  <div>
    <h4 class="mb-0">Seksi: {{ $seksiname->seksi_kode }}-{{ $seksiname->seksi_name }},</h4>
    <i>Laporan Grouping By Barang</i>
  </div>
  <a href="{{ route('laporan-bulanan.index') }}" class="btn btn-sm btn-secondary h-100">Kembali</a>
</div>
<hr>
<div class="card">
  <div class="card-header text-md-start text-center">
    <div class="d-flex justify-content-between">
      <div class="nav-align-top">
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item" role="presentation">
            <button type="button" class="nav-link active waves-effect" role="tab" data-bs-toggle="tab"
              data-bs-target="#navs-top-home" aria-controls="navs-top-home" aria-selected="true">Grouping</button>
          </li>
          <li class="nav-item" role="presentation">
            <button type="button" class="nav-link waves-effect" role="tab" data-bs-toggle="tab"
              data-bs-target="#navs-top-profile" aria-controls="navs-top-profile" aria-selected="false"
              tabindex="-1">Seluruh Transaksi</button>
          </li>
          <span class="tab-slider" style="left: 0px; width: 90.2344px; bottom: 0px;"></span>
        </ul>
      </div>
      <i class="text-primary">Bulan {{ $month }}, Tahun {{ $year }}</i>
    </div>
  </div>
  <div class="card-datatable text-nowrap">
    <div class="tab-content p-0">
      <div class="tab-pane fade show active" id="navs-top-home" role="tabpanel">
        <table class="datatables-ajax table table-bordered small" id="tableData">
          <thead>
            <tr class="text-center">
              <th class="sorting small" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
                style="width: 180px;" aria-label="E-mail: activate to sort column ascending">Kode</th>
              <th class="sorting small" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
                style="width: 150px;" aria-label="City: activate to sort column ascending">Barang</th>
              <th class="sorting small" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
                style="width: 70px;" aria-label="City: activate to sort column ascending">Qty Bon</th>
              <th class="sorting small" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
                style="width: 78px;" aria-label="Salary: activate to sort column ascending">Satuan</th>
            </tr>
          </thead>
          <tbody class="list">
            @foreach ($detail as $item)
            <tr role="row" class="odd ">
              {{-- <th scope="row" class="text-center">{{ $loop->iteration }}.</th> --}}
              <td class="text-center">{{ $item->code ?? 'not found' }}</td>
              <td class="text-center">{{ $item->name ?? '' }}</td>
              <td class="text-center">{{ $item->total ?? 0 }}</td>
              <td class="text-center">{{ $item->satuan ?? '' }}</td>
            </tr>

            @endforeach
          </tbody>
        </table>
      </div>
      <div class="tab-pane fade" id="navs-top-profile" role="tabpanel">
        <table class="datatables-ajax table table-bordered small" id="tableDataAll">
          <thead>
            <tr class="text-center">
              <th class="sorting small" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
                style="width: 180px;" aria-label="E-mail: activate to sort column ascending">Kode Transaksi</th>
              <th class="sorting small" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
                style="width: 180px;" aria-label="E-mail: activate to sort column ascending">Kode Barang</th>
              <th class="sorting small" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
                style="width: 150px;" aria-label="City: activate to sort column ascending">Barang</th>
              <th class="sorting small" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
                style="width: 70px;" aria-label="City: activate to sort column ascending">Tanggal</th>
              <th class="sorting small" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
                style="width: 70px;" aria-label="City: activate to sort column ascending">Qty Bon</th>
              <th class="sorting small" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
                style="width: 78px;" aria-label="Salary: activate to sort column ascending">Satuan</th>
            </tr>
          </thead>
          <tbody class="list">
            @foreach ($detailAll as $item)
            <tr role="row" class="odd ">
              {{-- <th scope="row" class="text-center">{{ $loop->iteration }}.</th> --}}
              <td class="text-center">
                <a href="{{ route('transaksi.show', $item->transaksi_id) }}" class="text-primary "><u>{{
                    $item->code ?? '' }}</u> </a>
              </td>
              <td class="text-center">{{ $item->barang_code ?? '' }}</td>
              <td class="text-center">{{ $item->barang_name ?? '' }}</td>
              <td class="text-center">{{ $item->tanggal ?? '' }}</td>
              <td class="text-center">{{ $item->total ?? 0 }}</td>
              <td class="text-center">{{ $item->satuan ?? '' }}</td>
            </tr>

            @endforeach
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>
<script src="{{asset('assets/vendor/libs/jquery/jquery.js')}}"></script>

<script>
  $(document).ready(function () {
        var table = $('#tableData').DataTable();
        var table2 = $('#tableDataAll').DataTable();
    });
</script>



@endsection