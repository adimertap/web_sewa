@extends('layouts/layoutMaster')

@section('title', 'Cetak Mutasi')

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

<div class="card">
  <div class="card-datatable text-nowrap">
    <table class="datatables-ajax table table-bordered small" id="tableData">
      <thead>
        <tr>
          <th rowspan="2" class="sorting sorting_asc text-center small" tabindex="0" aria-controls="DataTables_Table_1"
            colspan="1" style="width: 10px;" aria-label="Name: activate to sort column descending"
            aria-sort="ascending">No</th>
          <th colspan="4" rowspan="1" class="text-center small">Transaksi</th>
          <th colspan="4" rowspan="1" class="text-center small">Qty</th>
        </tr>
        <tr class="text-center">
          <th class="sorting small" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
            style="width: 180px;" aria-label="E-mail: activate to sort column ascending">Barang</th>
          <th class="sorting small" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
            style="width: 70px;" aria-label="City: activate to sort column ascending">Tanggal</th>
          <th class="sorting small" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
            style="width: 70px;" aria-label="City: activate to sort column ascending">Status</th>
          <th class="sorting small" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
            style="width: 70px;" aria-label="Position: activate to sort column ascending">Stok Awal</th>
          <th class="sorting small" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
            style="width: 78px;" aria-label="Salary: activate to sort column ascending">Qty Masuk</th>
          <th class="sorting small" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
            style="width: 78px;" aria-label="Salary: activate to sort column ascending">Qty Keluar</th>
          <th class="sorting small" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
            style="width: 78px;" aria-label="Salary: activate to sort column ascending">Stok Akhir</th>
        </tr>
      </thead>
      <tbody class="list">
        @foreach ($opname as $item)
        <tr role="row" class="odd ">
          <th scope="row" class="text-center">{{ $loop->iteration }}.</th>
          <td class="text-center">{{ $item->Barang->barang_name ?? '' }}</td>
          <td class="text-center">{{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') :
            '' }}</td>
          <td class="text-center">{{ $item->status ?? '' }}</td>
          <td class="text-center">{{ $item->stok_awal ?? 0 }}</td>
          <td class="text-center">{{ $item->qty_masuk ?? 0 }}</td>
          <td class="text-center">{{ $item->qty_keluar ?? 0 }}</td>
          <td class="text-center">{{ $item->stok_akhir ?? 0 }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
<script src="{{asset('assets/vendor/libs/jquery/jquery.js')}}"></script>
<script>
  window.onload = function() {
        window.print();
    }
</script>



@endsection