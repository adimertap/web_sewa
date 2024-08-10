@extends('layouts/layoutMaster')

@section('title', 'Laporan Bulanan')

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

<form action="{{ route('laporan-bulanan.index') }}" method="GET">
  <div class="card mb-3">
    <div class="card-header">Filter</div>
    <div class="card-body">
      <div class="row">
        <div class="col-4">
          <div class="form-floating form-floating-outline">
            <select id="seksiFilter" name="seksiFilter" class="form-select @error('seksiFilter') is-invalid @enderror">
              <option value="">Filter By Seksi</option>
              @foreach ($seksi as $item)
              <option value="{{ $item->seksi_id }}" {{ request('seksiFilter')==$item->seksi_id ? 'selected' : '' }}>
                {{ $item->seksi_kode }} - {{ $item->seksi_name }}
              </option>
              @endforeach
            </select>
            <label>Seksi</label>
          </div>
        </div>
        <div class="col-4">
          <div class="form-floating form-floating-outline">
            <select id="monthFilter" name="monthFilter" class="form-select @error('monthFilter') is-invalid @enderror">
              <option value="">Filter By Month</option>
              @for ($i = 1; $i <= 12; $i++) <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}" {{
                request('monthFilter')==str_pad($i, 2, '0' , STR_PAD_LEFT) ? 'selected' : '' }}>
                {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                </option>
                @endfor
            </select>
            <label>Month</label>
          </div>
        </div>
        <div class="col-4">
          <div class="form-floating form-floating-outline">
            <select id="yearFilter" name="yearFilter" class="form-select @error('yearFilter') is-invalid @enderror">
              <option value="">Filter By Year</option>
              @for ($year = 2020; $year <= 2030; $year++) <option value="{{ $year }}" {{ request('yearFilter')==$year
                ? 'selected' : '' }}>
                {{ $year }}
                </option>
                @endfor
            </select>
            <label>Year</label>
          </div>
        </div>
      </div>
      <div class="d-flex justify-content-start mt-4">
        <button type="submit" class="btn btn-sm btn-primary me-2">Apply</button>
        <a href="{{ route('laporan-bulanan.index') }}" class="btn btn-sm btn-danger">Reset</a>
      </div>
    </div>
  </div>
</form>



<div class="card">
  <div class="card-header text-md-start text-center">
    <div class="d-flex justify-content-between">
      <h5>Laporan Bulanan 📕</h5>
      <div>
        <button onclick="cetakLaporan()" class="btn btn-sm btn-primary me-5">Cetak Laporan BUlanan</button>
        {{-- <button onclick="resetopname()" class="btn btn-sm btn-danger me-3 ms-5">Reset Opname</button>
        <form id="reset-opname-form" action="{{ route('opname.reset') }}" method="post" style="display: none">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
        <button onclick="resetstok()" class="btn btn-sm btn-danger me-3">Reset Stok</button>
        <form id="reset-stok-form""
                    action=" {{ route('opname.reset.stok') }}" method="post" style="display: none">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
        <button onclick="resettransaksi()" class="btn btn-sm btn-danger">Reset Transaksi</button>
        <form id="reset-transaksi-form""
                    action=" {{ route('opname.reset.transaksi') }}" method="post" style="display: none">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form> --}}
      </div>
      {{-- <button type="button" id="btn-tambah" data-bs-toggle="modal" data-bs-target="#modalTambah"
        class="btn btn-primary waves-effect waves-light">Tambah</button> --}}
    </div>
  </div>
  <div class="card-datatable text-nowrap">
    <table class="datatables-ajax table table-bordered small" id="tableData">
      <thead>
        <tr class="text-center">
          {{-- <th class="sorting small" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
            style="width: 180px;" aria-label="E-mail: activate to sort column ascending">No.</th> --}}
          <th class="sorting small" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
            style="width: 180px;" aria-label="E-mail: activate to sort column ascending">Seksi</th>
          <th class="sorting small" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
            style="width: 150px;" aria-label="City: activate to sort column ascending">Bulan</th>
          <th class="sorting small" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
            style="width: 70px;" aria-label="City: activate to sort column ascending">Tahun</th>
          <th class="sorting small" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
            style="width: 70px;" aria-label="City: activate to sort column ascending">Total Transaksi</th>
          <th class="sorting small" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
            style="width: 78px;" aria-label="Salary: activate to sort column ascending">Detail</th>
        </tr>
      </thead>
      <tbody class="list">
        @foreach ($tr as $item)
        @if($item->seksi)
        <tr role="row" class="odd ">
          {{-- <th scope="row" class="text-center">{{ $loop->iteration }}.</th> --}}
          <td class="text-center">{{ $item->seksi ?? 'not found' }}</td>
          <td class="text-center">{{ $item->month ?? '' }}</td>
          <td class="text-center">{{ $item->year ?? '' }}</td>
          <td class="text-center">{{ $item->jumlah_transaksi ?? 0 }} Transaksi</td>
          <td class="text-center">
            <a href="{{ route('laporan-bulanan.detail', ['month' => $item->month, 'year' => $item->year, 'seksi' => $item->seksi_id]) }}"
              type="button" class="btn btn-sm btn-primary text-white rounded-pill waves-effect">
              Detail
            </a>
          </td>

        </tr>
        @endif

        @endforeach
      </tbody>
    </table>
  </div>
</div>
<div class="modal fade show  " id="modalCetak" aria-modal="true" role="dialog">
  <div class="modal-dialog modal-simple modal-dialog-centered">
    <div class="modal-content" style="padding: 2rem!important">
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      <div class="modal-header">
        <h5>Cetak Laporan</h5>
      </div>
      <div class="modal-body p-2">
        <form action="{{ route('laporan-bulanan.cetak')}}" id="qStokOpname" class="row g-5 mt-3" method="POST"
          target="_blank" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="row mt-3">
            <div class="form-floating form-floating-outline">
              <select type="text" id="barangCetak" name="barangCetak" class="form-select"
                value="{{ old('barangCetak') }}">
                <option value="">Seluruh Barang</option>
                @foreach ($barang as $item)
                <option value="{{ $item->barang_id }}">
                  {{ $item->barang_name }}
                </option>
                @endforeach
              </select>
              <label>Filter By Barang</label>
            </div>
          </div>
          <div class="row mt-3">
            <div class="form-floating form-floating-outline">
              <select type="text" id="seksiCetak" name="seksiCetak" class="form-select" value="{{ old('seksiCetak') }}">
                <option value="">Seluruh Seksi</option>
                @foreach ($seksi as $item)
                <option value="{{ $item->seksi_id }}">
                  {{ $item->seksi_kode }} - {{ $item->seksi_name }}
                </option>
                @endforeach
              </select>
              <label>Filter By Seksi</label>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-12">
              <div class="form-floating form-floating-outline">
                <select id="monthFilter" name="monthFilter"
                  class="form-select @error('monthFilter') is-invalid @enderror">
                  <option value="">Filter By Month</option>
                  @for ($i = 1; $i <= 12; $i++) <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}" {{
                    request('monthFilter')==str_pad($i, 2, '0' , STR_PAD_LEFT) ? 'selected' : '' }}>
                    {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                    </option>
                    @endfor
                </select>
                <label>Month</label>
              </div>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-12">
              <div class="form-floating form-floating-outline">
                <select id="yearFilter" name="yearFilter" class="form-select @error('yearFilter') is-invalid @enderror">
                  <option value="">Filter By Year</option>
                  @for ($year = 2020; $year <= 2030; $year++) <option value="{{ $year }}" {{
                    request('yearFilter')==$year ? 'selected' : '' }}>
                    {{ $year }}
                    </option>
                    @endfor
                </select>
                <label>Year</label>
              </div>
            </div>
          </div>
          {{-- <div class="row mt-3">
            <div class="col-md-6">
              <div class="form-floating form-floating-outline">
                <input type="date" id="start_date" name="start_date" class="form-control"
                  value="{{ old('start_date') }}" placeholder="Input Start Date">
                <label>Start Date</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating form-floating-outline">
                <input type="date" id="end_date" name="end_date" class="form-control" value="{{ old('end_Date') }}"
                  placeholder="Input End Date">
                <label>End Date</label>
              </div>
            </div>
          </div> --}}
          <hr>
          <div class="row mt-3">
            <div class="d-flex flex-wrap justify-content-between">
              <button type="reset" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="modal"
                aria-label="Close">Cancel</button>
              <button type="submit" class="btn btn-primary waves-effect waves-light">Cetak</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script src="{{asset('assets/vendor/libs/jquery/jquery.js')}}"></script>
<script>
  function cetakLaporan() {
        $('#modalCetak').modal('show');
    }
    function resetopname() {
        event.preventDefault();
        Swal.fire({
            title: 'Konfirmasi Reset',
            text: "Apakah Anda yakin untuk reset seluruh stok opname?, reset stok opname akan mendelete semua stok opname pada halaman ini",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya! Reset'
        }).then((result) => {
            if (result.isConfirmed) {
                event.preventDefault()
                document.getElementById('reset-opname-form').submit()
            }
        })
    }

    function resetstok() {
        event.preventDefault();
        Swal.fire({
            title: 'Konfirmasi Reset',
            text: "Apakah Anda yakin untuk reset seluruh stok Barang?, reset stok barang akan mengakibatkan seluruh barang menjadi 0",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya! Reset'
        }).then((result) => {
            if (result.isConfirmed) {
                event.preventDefault()
                document.getElementById('reset-stok-form').submit()
            }
        })
    }

    function resettransaksi(){
        event.preventDefault();
        Swal.fire({
            title: 'Konfirmasi Reset',
            text: "Apakah Anda yakin untuk reset seluruh Transaksi?, transaksi akan terhapus semuanya",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya! Reset'
        }).then((result) => {
            if (result.isConfirmed) {
                event.preventDefault()
                document.getElementById('reset-transaksi-form').submit()
            }
        })
    }

    $(document).ready(function () {
        var table = $('#tableData').DataTable();
    });
</script>



@endsection