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
    @if($month == null && $year == null)
    <p class="mt-3">Seluruh Bulan dan Tahun</p>

    @else
    <p class="mt-3">Pelaporan Bulan: {{ $month || '' }}, {{ $year || '' }}</p>

    @endif
    <table class="datatables-ajax table table-bordered small" id="tableData" style="font-size: 10px!important">
      <thead>
        <tr class="text-center">
          <th class="sorting small" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
            style="width: 20px!imporant; font-size: 8px!important">No.
          </th>
          <th class="sorting small" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
            style="width: 140px!imporant; font-size: 8px!important">Seksi
          </th>
          <th class="sorting small" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
            style="width: 50px!imporant; font-size: 8px!important">Kode
          </th>
          <th class="sorting small" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
            style="width: 70px!imporant; font-size: 8px!important">Barang
          </th>
          <th class="sorting small" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
            style="width: 40px!imporant; font-size: 8px!important">Qty
          </th>
          <th class="sorting small" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
            style="width: 40px!imporant; font-size: 8px!important">Satuan
          </th>
        </tr>
      </thead>
      <tbody class="list">
        @foreach ($detail as $item)
        <tr role="row" class="odd" style="font-size: 8px!important">
          <th scope="row" class="text-center" style="font-size: 8px!important">{{ $loop->iteration }}.</th>
          <td class="text-center">{{ $item->seksi_kode ?? '' }} - {{ $item->seksi ?? '' }}</td>
          <td class="text-center">{{ $item->code ?? '' }}</td>
          <td class="text-center">{{ $item->name ?? '' }}</td>
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