@extends('layouts/layoutMaster')

@section('title', 'Detail Transaksi')

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
  <div class="col-xl-9 col-md-8 col-12 mb-md-0 mb-6">
    <div class="card invoice-preview-card p-sm-8 p-4">
      <div class="card-body invoice-preview-header rounded-4 p-4">
        <div
          class="d-flex justify-content-between flex-xl-row flex-md-column flex-sm-row flex-column text-heading align-items-xl-center align-items-md-start align-items-sm-center flex-wrap gap-6">
          <div>
            <div class="d-flex svg-illustration align-items-center gap-2 mb-6">
              {{-- <span
                class="app-brand-logo demo">@include('_partials.macros',["width"=>25,"withbg"=>'var(--bs-primary)'])</span>
              --}}
              <span class="mb-0 app-brand-text fw-semibold demo">Bon Barang</span>
            </div>
            <i class="mb-1">Seksi: <b>{{ $tr->Seksi->seksi_kode ?? '' }}</b></i>
            <p class="mb-1">{{ $tr->Seksi->seksi_name ?? '' }}</p>
          </div>
          <div>
            <h5 class="mb-6">#{{ $tr->transaksi_code }}</h5>
            <div class="mb-1">
              <span>Date:</span>
              <span>{{ \Carbon\Carbon::parse($tr->transaksi_date)->format('d F Y') }}</span>
            </div>
            <div>
              <span>Status:</span>
              <i>{{ $tr->transaksi_status }}</i>
            </div>
          </div>
        </div>
      </div>
      <div class="card-body py-4 px-0">
        {{-- <div class="d-flex justify-content-between flex-wrap gap-6">
          <div>
            <h6>Bon Barang Dari Seksi:</h6>
            <table>
              <tbody>
                <tr>
                  <td class="pe-4">Kode :</td>
                  <td>{{ $tr->Seksi->seksi_kode ?? '' }}</td>
                </tr>
                <tr>
                  <td class="pe-4">Seksi:</td>
                  <td>{{ $tr->Seksi->seksi_name ?? '' }}</td>
                </tr>

                <tr>
                  <td class="pe-4">Total:</td>
                  <td>{{ $tr->total_qty }} Barang</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div> --}}
        <i>Detail Barang Bon</i>
      </div>
      <div class="table-responsive border rounded-4 border-bottom-0">
        <table class="table m-0">
          <thead>
            <tr>
              <th>Kode</th>
              <th>Barang</th>
              @if(Auth::user()->role == 'Admin')
              <th class="text-center">Qty Actual</th>
              @endif
              <th class="text-center">Qty Bon</th>
              @if(Auth::user()->role == 'Admin' && $tr->transaksi_status == 'Pending')
              <th class="text-danger text-center">Setelah</th>
              <th class="text-center">Status</th>

              @endif
              <th class="text-center">Satuan</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($tr->Detail as $item)
            <tr>
              <td class="text-nowrap text-heading small">{{ $item->Barang->barang_code }}</td>
              <td class="text-nowrap small">{{ $item->Barang->barang_name }}</td>
              @if(Auth::user()->role == 'Admin')
              <td class="small text-center">{{ $item->Barang->qty }}</td>
              @endif
              <td class="small text-center">{{ $item->qty }}</td>
              @if(Auth::user()->role == 'Admin' && $tr->transaksi_status == 'Pending')
              <td class="small text-center text-danger">{{ $item->Barang->qty - $item->qty }}</td>
              @if($item->Barang->status == 'Cukup')
              <td class="small text-center">Cukup</td>
              @elseif ($item->Barang->status == 'Habis')
              <td class="small text-center text-danger">Habis</td>
              @elseif ($item->Barang->status == 'Hampir Habis')
              <td class="small text-center text-warning">Hampir Habis</td>
              @endif


              @endif
              <td class="small text-center">{{ $item->Barang->satuan }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="table-responsive">
        <table class="table m-0 table-borderless">
          <tbody>
            <tr>
              <td class="align-top px-0 py-6 text-end">
                <p class="mb-1">
                  @if($tr->transaksi_status == 'Reject')
                  <span class="me-2 fw-medium text-heading">Reject By:</span>
                  @elseif ($tr->transaksi_status == 'Approved')
                  <span class="me-2 fw-medium text-heading">Approved By:</span>
                  @else
                  <span class="me-2 fw-medium text-heading">On Progress</span>

                  @endif
                  <span>{{ $tr->ApprovedBy->name ?? '' }}</span>

                </p>
                <span>{{ $tr->ApprovedBy->email ?? '' }}</span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <hr class="mt-0 mb-6">
      <div class="card-body p-0">
        <div class="row">
          <div class="col-12">
            <span class="fw-medium text-heading">Note:</span>
            @if($tr->transaksi_status == 'Pending')
            <span>Invoice bon barang akan direview terlebih dahulu oleh Admin yang selanjutnya akan di
              approve atau reject! Terima Kasih. </span>
            @elseif ($tr->transaksi_status == 'Approved')
            <span>Invoice bon barang telah di approve oleh Admin, nota dapat dibawa saat pengambilan barang!
              Terima Kasih. </span>
            @elseif ($tr->transaksi_status == 'Reject')
            <span>Mohon maaf, Invoice bon barang telah di reject oleh Admin dengan keterangan terlampir,
              Terima Kasih! </span>
            @elseif ($tr->transaksi_status == 'Selesai')
            <span>Invoice bon barang telah di selesai diproses!
              Terima Kasih. </span>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /Invoice -->

  <!-- Invoice Actions -->
  <div class="col-xl-3 col-md-4 col-12 invoice-actions">
    <div class="card">
      <div class="card-body">
        <p class="mb-2">Status:
          @if($tr->transaksi_status == 'Approved')
          <span class="text-success">{{ $tr->transaksi_status }}</span>
          @elseif ($tr->transaksi_status == 'Pending')
          <span class="text-primary">{{ $tr->transaksi_status }}</span>
          @elseif($tr->transaksi_status == 'Reject')
          <span class="text-danger">{{ $tr->transaksi_status }}</span>
          @else
          <span>{{ $tr->transaksi_status }}</span>
          @endif
        </p>
        @if($tr->keterangan != null)
        <span>{{ $tr->keterangan }}</span>
        @endif

        <hr>

        @if(Auth::user()->role == 'Admin' && $tr->transaksi_status == 'Approved')
        <form id="selesai-form-{{ $tr->transaksi_id }}" action="{{ route('transaksi.selesai', $tr->transaksi_id) }}"
          method="post" style="display: none">
          @method('PUT')
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
        @endif

        @if(Auth::user()->role == 'Admin' && $tr->transaksi_status == 'Pending')

        <button class="btn btn-success d-grid w-100 mb-2" type="button"
          onclick="approveFunction({{ $tr->transaksi_id }})">
          <span class="d-flex align-items-center justify-content-center text-nowrap"><i
              class="ri-check-line ri-16px scaleX-n1-rtl me-2"></i>Approve</span>
        </button>
        <form id="approve-form-{{ $tr->transaksi_id }}" action="{{ route('transaksi.selesai', $tr->transaksi_id) }}"
          method="post" style="display: none">
          @method('PUT')
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
        <button class="btn btn-danger d-grid w-100 mb-2" onclick="rejectFunction({{ $tr->transaksi_id }})">
          <span class="d-flex align-items-center justify-content-center text-nowrap"><i
              class="ri-alert-line ri-16px scaleX-n1-rtl me-2"></i>Reject</span>
        </button>
        <form id="reject-form-{{ $tr->transaksi_id }}" action="{{ route('transaksi.reject', $tr->transaksi_id) }}"
          method="post" style="display: none">
          @method('PUT')
          <input type="hidden" name="keteranganReject" id="keteranganReject">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
        @endif
        <a class="btn btn-outline-secondary d-grid w-100 mb-4" target="_blank"
          href="{{ route('transaksi.cetak', $tr->transaksi_id) }}">
          Print Bon Barang
        </a>
        <a href="{{ route('transaksi.index') }}" class="btn btn-dark d-grid w-100">
          <span class="d-flex align-items-center justify-content-center text-nowrap"><i
              class="ri-arrow-left-line ri-16px me-2"></i>Back to List</span>
        </a>


      </div>
    </div>
  </div>
</div>
<script src="{{asset('assets/vendor/libs/jquery/jquery.js')}}"></script>
<script>
  function approveFunction(itemId) {
        event.preventDefault();
        Swal.fire({
            title: 'Konfirmasi Approval',
            text: "Apakah Anda yakin untuk approve dokumen bon barang ini?",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya! Approve'
        }).then((result) => {
            if (result.isConfirmed) {
                event.preventDefault()
                document.getElementById(`approve-form-${itemId}`).submit()
            }
        })
    }

    function selesaiFunction(itemId) {
        event.preventDefault();
        Swal.fire({
            title: 'Konfirmasi Selesai',
            text: "Apakah Anda yakin untuk selesaikan dokumen bon barang ini? Selesai berarti Qty Barang akan berkurang dan stok opname tercreate otomatis",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya! Selesai'
        }).then((result) => {
            if (result.isConfirmed) {
                event.preventDefault()
                document.getElementById(`selesai-form-${itemId}`).submit()
            }
        })
    }
    function rejectFunction(itemId) {
        event.preventDefault();
        const { value: text } =  Swal.fire({
            title: 'Konfirmasi Reject',
            text: "Apakah Anda yakin untuk reject dokumen bon barang ini? ",
            icon: 'warning',
            input: "textarea",
            inputLabel: "Keterangan Reject",
            inputPlaceholder: "Input Keterangan Reject...",
            inputAttributes: {
                "aria-label": "Keterangan Reject"
            },
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya! Reject'
        }).then((result, text) => {
            if (result.isConfirmed) {
                event.preventDefault()
                $('#keteranganReject').val(result.value)
                document.getElementById(`reject-form-${itemId}`).submit()
            }
        })
    }






</script>



@endsection