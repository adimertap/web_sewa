{{-- @extends('layouts/layoutMaster') --}}

@extends('layouts.blankLayout')

@section('title', 'Cetak Laporan')

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

{{-- <div class="card">
  <div class="card-datatable text-nowrap"> --}}
    <table class="datatables-ajax table table-bordered small" id="tableData" style="font-size: 12px!important">
      <thead>
        <tr class="text-center">
          <th class="sorting small" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
            style="width: 20px; font-size: 12px" aria-label="E-mail: activate to sort column ascending">No.</th>
          <th class="sorting small" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
            style="width: 50px; font-size: 12px" aria-label="E-mail: activate to sort column ascending">Seksi</th>
          <th class="sorting small" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
            style="width: 100px; font-size: 12px" aria-label="City: activate to sort column ascending">Kode</th>
          <th class="sorting small" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
            style="width: 100px; font-size: 12px" aria-label="City: activate to sort column ascending">Barang</th>
          <th class="sorting small" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
            style="width: 40px; font-size: 12px" aria-label="Salary: activate to sort column ascending">Tanggal</th>
          <th class="sorting small" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
            style="width: 40px; font-size: 12px" aria-label="Salary: activate to sort column ascending">Qty</th>
          <th class="sorting small" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
            style="width: 50px; font-size: 12px" aria-label="Salary: activate to sort column ascending">Satuan</th>
        </tr>
      </thead>
      <tbody class="list">
        @foreach ($detail as $item)
        <tr role="row" class="odd ">
          <th scope="row" class="text-center">{{ $loop->iteration }}.</th>
          <td class="text-center">{{ $item->seksi_kode ?? '' }} - {{ $item->seksi ?? '' }}</td>
          <td class="text-center">{{ $item->code ?? '' }}</td>
          <td class="text-center">{{ $item->name ?? '' }}</td>
          <td class="text-center">{{ $item->date ? \Carbon\Carbon::parse($item->date)->format('d-m-Y') :'' }}</td>
          <td class="text-center">{{ $item->total ?? 0 }}</td>
          <td class="text-center">{{ $item->satuan ?? 0 }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    {{--
  </div>
</div> --}}
<script src="{{asset('assets/vendor/libs/jquery/jquery.js')}}"></script>
<script>
  window.onload = function() {
        window.print();
    }
</script>



@endsection