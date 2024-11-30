@extends('layouts/layoutMaster')

@section('title', 'Master User')

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
      <h5>Master User</h5>
      <button type="button" id="btn-tambah" data-bs-toggle="modal" data-bs-target="#modalTambah"
        class="btn btn-primary waves-effect waves-light">Tambah</button>
    </div>

  </div>
  <div class="card-datatable text-nowrap small">
    <table class="datatables-ajax table table-bordered" id="tableData">
      <thead>
        <tr>
          <th>No.</th>
          <th class="text-center">Nama</th>
          <th class="text-center">Email</th>
          <th class="text-center">Role</th>
          <th class="text-center">Status</th>
          <th class="text-center">Action</th>
        </tr>
      </thead>
      <tbody class="list">
        @foreach ($user as $item)
        <tr role="row" class="odd ">
          <th scope="row" class="text-center">{{ $loop->iteration }}.</th>
          <td class="text-center">{{ $item->name }}</td>
          <td class="text-center">{{ $item->email }}</td>
          <td class="text-center">
            <span class="text-truncate d-flex align-items-center text-heading"><i
                class="ri-computer-line ri-22px text-danger me-2"></i>Admin</span>
          </td>
          <td class="text-center">
            @if($item->active = 'A')
            <span class="badge rounded-pill  bg-label-success">Active</span>
            @else
            <span class="badge rounded-pill  bg-label-danger">Not Active</span>
            @endif
          </td>
          <td class="text-center">
            <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect editBtn"
              value="{{ $item->id }}">
              <i class="ri-edit-box-line ri-20px"></i>
            </button>
            <button type="button" class="btn btn-sm btn-icon btn-text-danger rounded-pill waves-effect  deleteBtn"
              value="{{ $item->id }}" onclick="deleteFunction({{ $item->id }})">
              <i class="ri-delete-bin-7-line ri-20px"></i>
            </button>
            <form id="delete-form-{{ $item->id }}" action="{{ route('user.destroy', $item->id) }}" method="post"
              style="display: none">
              @method('DELETE')
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </form>
            <button class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect dropdown-toggle hide-arrow"
              data-bs-toggle="dropdown"><i class="ri-more-2-line ri-20px"></i></button>
            <div class="dropdown-menu dropdown-menu-end m-0">
              <button type="button" class="dropdown-item" value="{{ $item->id }}"
                onclick="modalPasswordFunction({{ $item->id }})">
                <i class="ri-edit-box-line me-2"></i><span>Change Password</span>
              </button>
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
          <h4 class="mb-2" id="modalTitle">Tambah Data User</h4>
          <p class="mb-3">Lengkapi Form Berikut Ini</p>
        </div>
        <form action="{{ route('user.store')}}" id="userForm" class="row g-5" method="POST"
          enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="userId" id="userId">
          <div class="col-12 fv-plugins-icon-container mt-5">
            <div class="form-floating form-floating-outline">
              <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name') }}" placeholder="Input Username">
              <label>Username <span class="mr-4 mb-3" style="color: red">*</span></label>
              @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="col-12 col-md-12 mt-3">
            <div class="form-floating form-floating-outline">
              <input type="text" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}" placeholder="Input Email User">
              <label>Email <span class="mr-4 mb-3" style="color: red">*</span></label>
              @error('email')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="col-12 col-md-12 mt-3" id="tempPassword">
            <div class="form-floating form-floating-outline">
              <input type="password" id="password_user" name="password_user"
                class="form-control @error('password_user') is-invalid @enderror" placeholder="Input Password User">
              <label>Password</label>
              @error('password_user')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <i><span class="mt-4 text-danger">(*)</span> Wajib Diisi, lengkapi form</i>
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

<div class="modal fade  " id="modalPassword" tabindex="-1" aria-modal="true">
  <div class="modal-dialog modal-simple modal-enable-otp modal-dialog-centered">
    <div class="modal-content">
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      <div class="modal-body p-0">
        <div class="text-center mb-6">
          <h4 class="mb-2">Change Password 🔐</h4>
          <p>Lengkapi form berikut untuk perubahan Password</p>
        </div>
        <hr>
        <p class="mb-1">Ubah Password User,
          Password diharuskan terdiri dari string dan angka</p>
        <form action="{{ route('user-change-password') }}" method="POST">
          @csrf
          <input type="hidden" name="userIdPass" id="userIdPass">
          <div class="form-floating form-floating-outline mt-3">
            <input type="password" id="password_user" name="password_user"
              class="form-control @error('password_user') is-invalid @enderror" placeholder="Input Password User">
            <label>Password</label>
            @error('password_user')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="form-floating form-floating-outline mt-3">
            <input type="password" id="confirm_password" name="confirm_password"
              class="form-control @error('confirm_password') is-invalid @enderror" placeholder="Confirm Password">
            <label>Confirm Password</label>
            @error('confirm_password')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-12 d-flex flex-wrap justify-content-center gap-4 row-gap-4 mt-5">
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
            $.ajax({
                method: 'get',
                url: '/Master/user/' + id,
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
                        $('#modalTitle').text('Edit Data User');
                        $('#tempPassword').hide()
                        $('#userId').val(id);
                        $('input[name="name"]').val(response.name);
                        $('input[name="email"]').val(response.email);
                        $('#role').val(response.role);

                        let url = "{{ route('user.update', ':id')}}"
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
            $('#modalTitle').text('Tambah Data User');
            $('#userForm').attr('action', "{{ route('user.store') }}");
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
