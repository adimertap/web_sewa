@extends('layouts/layoutMaster')

@section('title', 'Account Detail')

@section('vendor-style')
{{--
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss')}}" /> --}}
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/animate-css/animate.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}" />
<link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">

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

<div class="row gy-6 gy-md-0">
  <!-- User Sidebar -->
  <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
    <!-- User Card -->
    <div class="card mb-4">
      <div class="card-body pt-5">
        <div class="user-avatar-section">
          <div class=" d-flex align-items-center flex-column">
            <img class="img-fluid rounded-3 mb-4" src="{{asset('assets/img/avatars/1.png')}}" height="120" width="120"
              alt="User avatar" />
            <div class="user-info text-center">
              <h5>{{ $user->name }}</h5>
              <span class="badge bg-label-danger rounded-pill">
                @if($user->role == "User")
                Pegawai {{ $user->Seksi->seksi_name }}
                @elseif ($user->role == "Petugas")
                Petugas Gudang
                @else
                Admin {{ $user->Seksi->seksi_name }}
                @endif
              </span>
            </div>
          </div>
        </div>

        <h5 class="pb-4 border-bottom mb-4">Details</h5>
        <div class="info-container">
          <ul class="list-unstyled mb-5">
            <li class="mb-2">
              <span class="fw-medium text-heading me-2">Nama:</span>
              <span>{{ $user->name }}</span>
            </li>
            <li class="mb-2">
              <span class="fw-medium text-heading me-2">Seksi:</span>
              <span>{{ $user->Seksi->seksi_name }}</span>
            </li>
            <li class="mb-2">
              <span class="fw-medium text-heading me-2">Email:</span>
              <span>{{ $user->email }}</span>
            </li>
            <li class="mb-2">
              <span class="fw-medium text-heading me-2">Role:</span>
              <span>{{ $user->role }}</span>
            </li>
            <li class="mb-2">
              <span class="fw-medium text-heading me-2">Contact:</span>
              <span>{{ $user->phone_number ?? '-' }}</span>
            </li>
            <li class="mb-2">
              <span class="fw-medium text-heading me-2">Status:</span>
              <span class="badge bg-label-success rounded-pill">Active</span>
            </li>
          </ul>
          {{-- <div class="d-flex justify-content-center">
            <a href="javascript:;" class="btn btn-outline-danger suspend-user">Deactive</a>
          </div> --}}
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
    <div class="card mb-3">
      <div class="d-flex justify-content-around flex-wrap my-4 gap-0 gap-md-1 gap-lg-5 p-3">
        <div class="d-flex align-items-center me-5 gap-4">
          <div class="avatar">
            <div class="avatar-initial bg-label-primary rounded-3">
              <i class='ri-time-line ri-20px'></i>
            </div>
          </div>
          <div>
            <h5 class="mb-0">{{ $countPending }} Kali</h5>
            <span>Pending</span>
          </div>
          <div class="avatar">
            <div class="avatar-initial bg-label-success rounded-3">
              <i class='ri-check-line ri-20px'></i>
            </div>
          </div>
          <div>
            <h5 class="mb-0">{{ $countApproved }} Kali</h5>
            <span>Setuju</span>
          </div>
          <div class="avatar">
            <div class="avatar-initial bg-label-danger rounded-3">
              <i class='ri-alert-line ri-20px'></i>
            </div>
          </div>
          <div>
            <h5 class="mb-0">{{ $countReject }} Kali</h5>
            <span>Reject </span>
          </div>
          <div class="avatar">
            <div class="avatar-initial bg-label-success rounded-3">
              <i class='ri-check-line ri-20px'></i>
            </div>
          </div>
          <div>
            <h5 class="mb-0">{{ $countSelesai }} Kali</h5>
            <span>Selesai</span>
          </div>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-header">
        <h5>History Bon Barang</h5>
      </div>
      <div class="card-datatable text-nowrap">
        <table class="datatables-ajax table table-bordered" id="tableData">
          <thead>
            <tr>
              <th>No.</th>
              <th class="text-center">Kode</th>
              <th class="text-center">Tanggal</th>
              <th class="text-center">Total Barang</th>
              <th class="text-center">Status</th>
            </tr>
          </thead>
          <tbody class="list">
            @foreach ($tr as $item)
            <tr role="row" class="odd ">
              <th scope="row" class="text-center">{{ $loop->iteration }}.</th>
              <td class="text-center">
                <a href="{{ route('transaksi.show', $item->transaksi_id) }}" class="text-primary "><u>{{
                    $item->transaksi_code }}</u> </a>

              </td>
              <td class="text-center">{{ \Carbon\Carbon::parse($item->transaksi_date)->format('d F Y') }}
              </td>
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
</div>
<script src="{{asset('assets/vendor/libs/jquery/jquery.js')}}"></script>

<script>
  $(document).ready(function () {
        var table = $('#tableData').DataTable();

     })
</script>
@endsection