@extends('layouts/layoutMaster')

@section('title', 'Master Sistem Bayar')

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

<div class="card">
  <div class="card-header text-md-start text-center">
    <div class="d-flex justify-content-between">
      <h5>Master Sistem Pembayaran</h5>
      <button type="button" id="btn-tambah" data-bs-toggle="modal" data-bs-target="#modalTambah"
        class="btn btn-primary waves-effect waves-light">Tambah</button>
    </div>

  </div>
  <div class="card-datatable text-nowrap small">
    <table class="datatables-ajax table table-bordered" id="tableData">
      <thead>
        <tr>
          <th>No.</th>
          <th class="text-center">Sistem Pembayaran</th>
          <th class="text-center">Status</th>
          <th class="text-center">Action</th>
        </tr>
      </thead>
      <tbody class="list">
        @foreach ($sistem as $item)
        <tr role="row" class="odd ">
          <th scope="row" class="text-center">{{ $loop->iteration }}.</th>
          <td class="text-center">{{ $item->sistem_pembayaran }}</td>
          <td class="text-center">
            <span class="badge rounded-pill  bg-label-success">Active</span>
          </td>
          <td class="text-center">
            <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect editBtn"
              value="{{ $item->sistem_id }}">
              <i class="ri-edit-box-line ri-20px"></i>
            </button>
            <button type="button" class="btn btn-sm btn-icon btn-text-danger rounded-pill waves-effect  deleteBtn"
              value="{{ $item->sistem_id }}" onclick="deleteFunction({{ $item->sistem_id }})">
              <i class="ri-delete-bin-7-line ri-20px"></i>
            </button>
            <form id="delete-form-{{ $item->sistem_id }}" action="{{ route('sistem-bayar.destroy', $item->sistem_id) }}"
              method="post" style="display: none">
              @method('DELETE')
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-simple modal-dialog-centered">
    <div class="modal-content">
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      <div class="modal-body p-0">
        <div class="text-center mb-6">
          <h4 class="mb-2" id="modalTitle">Tambah Data Siste Pembayaran</h4>
          <p class="mb-3">Lengkapi Form Berikut Ini</p>
        </div>
        <form action="{{ route('sistem-bayar.store')}}" id="userForm" class="row g-5" method="POST"
          enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="sistemId" id="sistemId">
          <div class="col-12 fv-plugins-icon-container mt-5">
            <div class="form-floating form-floating-outline">
              <input type="text" id="sistem_pembayaran" name="sistem_pembayaran"
                class="form-control @error('sistem_pembayaran') is-invalid @enderror"
                value="{{ old('sistem_pembayaran') }}" placeholder="Input Nama Sistem Pembayaran">
              <label>Sistem Pembayaran<span class="mr-4" style="color: red">*</span></label>
              @error('sistem_pembayaran')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <i class="mt-1"><span class="mt-1 text-danger">(*)</span> Wajib Diisi, lengkapi form</i>
          <div class="mt-5 col-12 text-center d-flex flex-wrap justify-content-center gap-4 row-gap-4">
            <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
            <button type="reset" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="modal"
              aria-label="Close">Cancel</button>
          </div>
        </form>
      </div>
    </div>
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

    function modalPasswordFunction(itemId) {
        $('#userIdPass').val(itemId)
        $('#modalPassword').modal('show')
    }

    $(document).ready(function () {
        var table = $('#tableData').DataTable();
        table.on('click', '.editBtn', function () {
            var id = $(this).val();
            console.log(id)
            $.ajax({
                method: 'get',
                url: '/Master/sistem-bayar/' + id,
                success: function (response) {
                  console.log(response)
                    if(response == 404){
                        Swal.fire({
                            title: 'Warning!',
                            text: ' Data Tidak Ditemukan!',
                            icon: 'warning',
                            customClass: {
                            confirmButton: 'btn btn-primary waves-effect waves-light'
                            },
                            buttonsStyling: false
                        })
                    }else{
                        $('#modalTambah').modal('show')
                        $('#btn-submit').text('Edit Data')
                        $('#modalTitle').text('Edit Data Sistem Pembayaran');
                        $('#tempPassword').hide()
                        $('#sistemId').val(id);
                        $('input[name="sistem_pembayaran"]').val(response.sistem_pembayaran);

                        let url = "{{ route('sistem-bayar.update', ':id')}}"
                        url = url.replace(':id', id)
                        $('#userForm').attr('action', url);
                        $('#userForm').attr('method', 'POST');
                        $('#userForm').append('<input type="hidden" name="_method" value="PUT">');

                    }
                },
                error: function (response) {
                    console.log(response);
                }
            });
        });

        $('#modalTambah').on('show.bs.modal', function (e) {
            $('#modalTitle').text('Tambah Data Sistem Pembayaran');
            $('#userForm').attr('action', "{{ route('sistem-bayar.store') }}");
            $('#userForm').attr('method', 'POST');
            $('#btn-submit').text('Save Data');
            $('#tempPassword').show();
            // $('#userForm').find('input, select').val('');
            $('#userId').val('');
            $('#name').val('');
            $('#email').val('');
            $('#role').val('');
            $('#password_user').val('');
        });
    });
    document.addEventListener('DOMContentLoaded', function () {
        @if ($errors->any())
            var modal = new bootstrap.Modal(document.getElementById('modalTambah'));
            modal.show();
        @endif
    });



</script>



@endsection