@extends('layouts/layoutMaster')

@section('title', 'Master Seksi')

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
      <h5>Master Seksi</h5>
      <button type="button" id="btn-tambah" data-bs-toggle="modal" data-bs-target="#modalTambah"
        class="btn btn-primary waves-effect waves-light">Tambah</button>
    </div>

  </div>
  <div class="card-datatable text-nowrap">
    <table class="datatables-ajax table table-bordered" id="tableData">
      <thead>
        <tr>
          <th>No.</th>
          <th class="text-center">Kode</th>
          <th class="text-center">Nama</th>
          <th class="text-center">Status</th>
          <th class="text-center">Action</th>
        </tr>
      </thead>
      <tbody class="list">
        @foreach ($seksi as $item)
        <tr role="row" class="odd ">
          <th scope="row" class="text-center">{{ $loop->iteration }}.</th>
          <td class="text-center">{{ $item->seksi_kode }}</td>
          <td class="text-center">{{ $item->seksi_name }}</td>
          <td class="text-center">
            @if($item->status = 'A')
            <span class="badge rounded-pill  bg-label-success">Active</span>
            @else
            <span class="badge rounded-pill  bg-label-danger">Not Active</span>
            @endif
          </td>
          <td class="text-center">
            <button type="button" class="btn  btn-text-secondary rounded-pill waves-effect editBtn"
              value="{{ $item->seksi_id }}">
              <i class="ri-edit-box-line "></i>
            </button>
            <button type="button" class="btn  btn-text-danger rounded-pill waves-effect  deleteBtn"
              value="{{ $item->seksi_id }}" onclick="deleteFunction({{ $item->seksi_id }})">
              <i class="ri-delete-bin-7-line"></i>
            </button>

            <form id="delete-form-{{ $item->seksi_id }}" action="{{ route('seksi.destroy', $item->seksi_id) }}"
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
<div class="modal fade  " id="modalTambah" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-simple modal-dialog-centered">
    <div class="modal-content">
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      <div class="modal-body p-0">
        <form action="{{ route('seksi.store')}}" id="seksiForm" class="row g-5" method="POST">
          @csrf
          <input type="hidden" name="seksiId" id="seksiId">
          <div class="text-center mb-6">
            <h4 class="mb-2" id="modalTitle">Tambah Data Seksi</h4>
            <p class="mb-6">Lengkapi Form Berikut Ini</p>
          </div>
          <div class="col-12 mt-2">
            <label>Kode Seksi<span class="mr-4 mb-3" style="color: red">*</span></label>
            <input type="number" id="kode" name="kode" class="form-control" value="{{ old('kode') }}"
              placeholder="Input Kode Seksi" />
          </div>
          <div class="col-12 mt-4 mb-4">
            <label>Nama Seksi<span class="mr-4 mb-3" style="color: red">*</span></label>
            <input type="text" id="nama" name="name" class="form-control @error('name') is-invalid @enderror"
              value="{{ old('name') }}" placeholder="Input Nama Seksi" />
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-12 text-center d-flex flex-wrap justify-content-center gap-4 row-gap-4">
            <button type="submit" class="btn btn-primary" id="btnSubmitForm">Submit</button>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
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
    $(document).ready(function () {
        var table = $('#tableData').DataTable();
        table.on('click', '.editBtn', function () {
            var id = $(this).val();
            $.ajax({
                method: 'get',
                url: '/Master/seksi/' + id,
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
                        $('#btnSubmitForm').text('Edit Data')
                        $('#modalTitle').text('Edit Data Seksi');
                        $('input[name="name"]').val(response.seksi_name);
                        $('input[name="kode"]').val(response.seksi_kode);
                        $('#modalEdit').modal('show');
                        if (response.seksi_id) {
                            var updateUrl = "{{ route('seksi.update', ['id' => '1']) }}";
                            $('#seksiForm').attr('action', updateUrl);
                            $('#seksiForm').attr('method', 'POST');
                            $('#seksiForm').append('<input type="hidden" name="_method" value="PUT">');
                            $('#seksiId').val(response.seksi_id);
                        }
                    }
                },
                error: function (response) {
                    console.log(response);
                }
            });
        });

        $('#modalTambah').on('show.bs.modal', function (e) {
            $('#modalTitle').text('Tambah Data Seksi');
            $('#seksiForm').attr('action', "{{ route('seksi.store') }}");
            $('#seksiForm').attr('method', 'POST');
            $('#btnSubmitForm').text('Save Data')
            $('#nama').val("")
            $('#kode').val("")
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