@extends('layouts/layoutMaster')

@section('title', 'Mutasi Barang')

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

<form action="{{ route('opname.index') }}" method="GET">
  <div class="card mb-3">
    <div class="card-header">
      Filter
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-4">
          <div class="form-floating form-floating-outline">
            <select type="text" id="barangFilter" name="barangFilter"
              class="form-select @error('barangFilter') is-invalid @enderror" value="{{ old('barangFilter') }}">
              <option value="">Filter By Barang</option>
              @foreach ($barang as $item)
              <option value="{{ $item->barang_id }}">
                {{ $item->barang_name }}
              </option>
              @endforeach
            </select>
            <label>Barang</label>
          </div>
        </div>
        <div class="col-4">
          <div class="form-floating form-floating-outline">
            <select type="text" id="monthFilter" name="monthFilter"
              class="form-select @error('monthFilter') is-invalid @enderror" value="{{ old('monthFilter') }}">
              <option value="">Filter By Month</option>
              <option value="01" {{ old('monthFilter')=='01' ? 'selected' : '' }}>Januari</option>
              <option value="02" {{ old('monthFilter')=='02' ? 'selected' : '' }}>Februari</option>
              <option value="03" {{ old('monthFilter')=='03' ? 'selected' : '' }}>Maret</option>
              <option value="04" {{ old('monthFilter')=='04' ? 'selected' : '' }}>April</option>
              <option value="05" {{ old('monthFilter')=='05' ? 'selected' : '' }}>Mei</option>
              <option value="06" {{ old('monthFilter')=='06' ? 'selected' : '' }}>Juni</option>
              <option value="07" {{ old('monthFilter')=='07' ? 'selected' : '' }}>Juli</option>
              <option value="08" {{ old('monthFilter')=='08' ? 'selected' : '' }}>Agustus</option>
              <option value="09" {{ old('monthFilter')=='09' ? 'selected' : '' }}>September</option>
              <option value="10" {{ old('monthFilter')=='10' ? 'selected' : '' }}>Oktober</option>
              <option value="11" {{ old('monthFilter')=='11' ? 'selected' : '' }}>November</option>
              <option value="12" {{ old('monthFilter')=='12' ? 'selected' : '' }}>Desember</option>
            </select>
            <label>Month</label>
          </div>
        </div>
        <div class="col-4">
          <div class="form-floating form-floating-outline">
            <select type="text" id="yearFilter" name="yearFilter"
              class="form-select @error('yearFilter') is-invalid @enderror" value="{{ old('monthFilter') }}">
              <option value="">Filter By Year</option>
              <option value="2020" {{ old('yearFilter')=='2020' ? 'selected' : '' }}>2020</option>
              <option value="2021" {{ old('yearFilter')=='2021' ? 'selected' : '' }}>2021</option>
              <option value="2022" {{ old('yearFilter')=='2022' ? 'selected' : '' }}>2022</option>
              <option value="2023" {{ old('yearFilter')=='2023' ? 'selected' : '' }}>2023</option>
              <option value="2024" {{ old('yearFilter')=='2024' ? 'selected' : '' }}>2024</option>
              <option value="2025" {{ old('yearFilter')=='2025' ? 'selected' : '' }}>2025</option>
              <option value="2026" {{ old('yearFilter')=='2026' ? 'selected' : '' }}>2026</option>
              <option value="2027" {{ old('yearFilter')=='2027' ? 'selected' : '' }}>2027</option>
              <option value="2028" {{ old('yearFilter')=='2028' ? 'selected' : '' }}>2028</option>
              <option value="2029" {{ old('yearFilter')=='2029' ? 'selected' : '' }}>2029</option>
              <option value="2030" {{ old('yearFilter')=='2030' ? 'selected' : '' }}>2030</option>
            </select>
            <label>Month</label>
          </div>
        </div>
      </div>
      <div class="d-flex justify-content-start mt-4">
        <button type="submit" class="btn btn-sm btn-primary me-2">Apply</button>
        <a href="{{ route('opname.index') }}" type="button" class="btn btn-sm btn-danger">Reset</a>

      </div>
    </div>
  </div>
</form>


<div class="card">
  <div class="card-header text-md-start text-center">
    <div class="d-flex justify-content-between">
      <h5>Mutasi Barang 📦</h5>
      <div>
        <button onclick="cetakOpname()" class="btn btn-sm btn-primary me-5">Cetak Mutasi</button>
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
            style="width: 150px;" aria-label="City: activate to sort column ascending">Transaksi</th>
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
          <td class="text-center">
            @if($item->Transaksi->transaksi_type == 'Rekam')
            <a href="{{ route('perekaman.show', $item->Transaksi->transaksi_id) }}" class="text-primary "><u>{{
                $item->Transaksi->transaksi_code }}</u> </a>
            @else
            <a href="{{ route('transaksi.show', $item->Transaksi->transaksi_id) }}" class="text-primary "><u>{{
                $item->Transaksi->transaksi_code }}</u> </a>
            @endif
          </td>
          <td class="text-center">{{ $item->tanggal ?? '' }}</td>
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

<div class="modal fade show animate__animated animate__jackInTheBox" id="modalCetak" aria-modal="true" role="dialog">
  <div class="modal-dialog modal-simple modal-dialog-centered">
    <div class="modal-content" style="padding: 2rem!important">
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      <div class="modal-header">
        <h5>Cetak Mutasi</h5>
      </div>
      <div class="modal-body p-0">
        <form action="{{ route('opname.cetak')}}" id="qStokOpname" class="row g-5 mt-3" method="POST" target="_blank"
          enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="row mt-2">
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
              <select type="text" id="jenis" name="jenis" class="form-select" value="{{ old('jenis') }}">
                <option value="">Seluruh Jenis</option>
                <option value="Masuk">Barang Masuk</option>
                <option value="Keluar">Barang Keluar</option>
              </select>
              <label>Filter By Jenis</label>
            </div>
          </div>
          <div class="row mt-3">
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
          </div>
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
  function cetakOpname() {
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