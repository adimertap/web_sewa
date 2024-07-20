@extends('layouts/layoutMaster')

@section('title', 'Transaksi')

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

{{-- <div class="row mb-4">
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
</div> --}}

@if(Auth::user()->role == 'Admin' || Auth::user()->role == 'Petugas')
<form action="{{ route('transaksi.index') }}" method="GET">
  <div class="card mb-3">
    <div class="card-header">
      Filter
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-3">
          <div class="form-floating form-floating-outline">
            <select type="text" id="statusFilter" name="statusFilter"
              class="form-select @error('statusFilter') is-invalid @enderror" value="{{ old('statusFilter') }}">
              <option value="">Filter By Status</option>
              <option value="Pending" {{ old('statusFilter')=='Pending' ? 'selected' : '' }}>Pending
              </option>
              <option value="Approved" {{ old('statusFilter')=='Approved' ? 'selected' : '' }}>Approved
              </option>
              <option value="Reject" {{ old('statusFilter')=='Reject' ? 'selected' : '' }}>Reject</option>
              <option value="Selesai" {{ old('statusFilter')=='Selesai' ? 'selected' : '' }}>Selesai
              </option>
            </select>
            <label>Status <span class="mr-4 mb-3" style="color: red">*</span></label>
          </div>
        </div>
        <div class="col-3">
          <div class="form-floating form-floating-outline">
            <select type="text" id="seksiFilter" name="seksiFilter"
              class="form-select @error('seksiFilter') is-invalid @enderror" value="{{ old('seksiFilter') }}">
              <option value="">Filter By Seksi</option>
              @foreach ($seksi as $item)
              <option value="{{ $item->seksi_id }}">
                {{ $item->seksi_kode }} - {{ $item->seksi_name }}
              </option>
              @endforeach
            </select>
            <label>Seksi</label>
          </div>
        </div>
        <div class="col-3">
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
        <div class="col-3">
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
      <div class="d-flex justify-content-end mt-4">
        <button type="submit" class="btn btn-sm btn-primary me-2">Apply</button>
        <a href="{{ route('transaksi.index') }}" type="button" class="btn btn-sm btn-danger">Reset</a>

      </div>
    </div>
  </div>
</form>
@endif


<div class="card">
  <div class="card-header text-md-start text-center">
    <div class="d-flex justify-content-between">
      <h5>History</h5>
      {{-- <button type="button" id="btn-tambah" data-bs-toggle="modal" data-bs-target="#modalTambah"
        class="btn btn-primary waves-effect waves-light">Tambah</button> --}}
    </div>

  </div>
  <div class="card-datatable text-nowrap small">
    <table class="datatables-ajax table table-bordered" id="tableData">
      <thead>
        <tr>
          <th>No.</th>
          @if(Auth::user()->role == 'Admin' || Auth::user()->role == 'Petugas')
          <th class="text-center">Seksi</th>
          @if(Auth::user()->role == 'Admin')
          <th class="text-center">User</th>
          @endif
          @endif
          <th class="text-center">Kode</th>
          <th class="text-center" style="max-width: 25px!important">Tanggal</th>
          <th class="text-center" style="max-width: 25px!important">Total</th>
          <th class="text-center" style="max-width: 30px!important">Status</th>
          <th class="text-center">Action</th>
        </tr>
      </thead>
      <tbody class="list">
        @foreach ($tr as $item)
        <tr role="row" class="odd ">
          <th scope="row" class="text-center">{{ $loop->iteration }}.</th>
          @if(Auth::user()->role == 'Admin' || Auth::user()->role == 'Petugas')
          <td class="text-center">{{ $item->User->Seksi->seksi_name ?? '' }}</td>
          @if(Auth::user()->role == 'Admin')
          <td class="text-center">{{ $item->User->name ?? '' }}</td>
          @endif
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
          <td class="text-center">
            @if($item->transaksi_status == 'Pending' || $item->transaksi_status == 'Rejcet')
            <a href="{{ route('transaksi.edit', $item->transaksi_id) }}" type="button"
              class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect editBtn">
              <i class="ri-edit-box-line ri-20px"></i>
            </a>
            <button type="button" class="btn btn-sm btn-icon btn-text-danger rounded-pill waves-effect  deleteBtn"
              value="{{ $item->transaksi_id }}" onclick="deleteFunction({{ $item->transaksi_id }})">
              <i class="ri-delete-bin-7-line ri-20px"></i>
            </button>
            <form id="delete-form-{{ $item->transaksi_id }}"
              action="{{ route('transaksi.destroy', $item->transaksi_id) }}" method="post" style="display: none">
              @method('DELETE')
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </form>
            @endif

            <a href="{{ route('transaksi.cetak', $item->transaksi_id) }}" type="button" target="_blank"
              class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect  cetakBtn">
              <i class="ri-printer-line ri-20px"></i>
            </a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
<script src="{{asset('assets/vendor/libs/jquery/jquery.js')}}"></script>
<script>
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
                event.preventDefault()
                document.getElementById(`delete-form-${itemId}`).submit()
            }
        })
    }


    $(document).ready(function () {
        var table = $('#tableData').DataTable();

    });



</script>



@endsection