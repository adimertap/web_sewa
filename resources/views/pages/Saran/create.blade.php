@extends('layouts/layoutMaster')
@section('title', 'Saran dan Masukan')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}" />
<link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
<script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
@endsection

@section('page-style')
<link rel="stylesheet" href="{{asset('assets/vendor/scss/pages/wizard-ex-checkout.css')}}" />
@endsection

@section('page-script')
<script src="{{asset('assets/js/extended-ui-sweetalert2.js')}}"></script>
<script src="{{asset('assets/js/forms-selects.js')}}"></script>

@endsection

@section('content')
@include('sweetalert::alert')

<form action="{{ route('saran.store')}}" id="saranStore" method="POST">
  @csrf
  <div class="card w-50 text-center">
    <div class="card-body">
      <div class="p-4 pt-3 pb-1 mb-0 mt-0">
        <h5 class="mb-0 mt-1">Tambah Saran dan Masukan</h5>
        <i class="mt-0 mb-3">Lengkapi Form Berikut Ini!</i>
        <hr>
        <textarea class="form-control form-control-sm" id="saran" name="saran"
          placeholder="Input Saran dan Masukan disini" rows="10">
        </textarea>
        <p class="text-muted mt-5 mb-0 small">Terima Kasih atas Masukan dan Saran dari Anda 👋</p>
      </div>
    </div>
    <div class="card-footer p-4 mt-0">
      <hr>
      <div class="d-flex justify-content-between">
        <a href="{{ route('transaksi.index') }}" class="btn btn-sm btn-secondary">Back</a>
        <button type="submit" class="btn btn-sm btn-primary">Kirim</button>
      </div>
    </div>
  </div>

</form>


<script src="{{asset('assets/vendor/libs/jquery/jquery.js')}}"></script>

<script>

</script>



@endsection