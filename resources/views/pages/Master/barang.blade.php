@extends('layouts/layoutMaster')

@section('title', 'Master Barang')

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

<div class="row mb-4">
  <div class="col-sm-6 col-lg-4">
    <div class="card card-border-shadow-primary h-100">
      <div class="card-body">
        <div class="d-flex align-items-center mb-2">
          <div class="avatar me-4">
            <span class="avatar-initial rounded-3 bg-label-primary"><i class="ri-check-line ri-24px"></i></span>
          </div>
          <h4 class="mb-0">{{ $cukup }}</h4>
        </div>
        <h6 class="mb-0 fw-normal">Total Barang Cukup</h6>
        <p class="mb-0">
          <span class="me-1 fw-medium">.</span>
          <small class="text-muted">Barang Cukup</small>
        </p>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-lg-4">
    <div class="card card-border-shadow-warning h-100">
      <div class="card-body">
        <div class="d-flex align-items-center mb-2">
          <div class="avatar me-4">
            <span class="avatar-initial rounded-3 bg-label-warning"><i class="ri-alert-line ri-24px"></i></span>
          </div>
          <h4 class="mb-0">{{ $hampirHabis }}</h4>
        </div>
        <h6 class="mb-0 fw-normal">Total Barang Hampir Habis</h6>
        <p class="mb-0">
          <span class="me-1 fw-medium">.</span>
          <small class="text-muted">Lakukan Pengecekan</small>
        </p>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-lg-4">
    <div class="card card-border-shadow-danger h-100">
      <div class="card-body">
        <div class="d-flex align-items-center mb-2">
          <div class="avatar me-4">
            <span class="avatar-initial rounded-3 bg-label-danger"><i class="ri-error-warning-line ri-24px"></i></span>
          </div>
          <h4 class="mb-0">{{ $habis }}</h4>
        </div>
        <h6 class="mb-0 fw-normal">Total Barang Habis</h6>
        <p class="mb-0">
          <span class="me-1 fw-medium">.</span>
          <small class="text-muted">Lakukan Restock</small>
        </p>
      </div>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-header text-md-start text-center">
    <div class="d-flex justify-content-between">
      <h5>Master Barang</h5>
      <button type="button" id="btn-tambah" data-bs-toggle="modal" data-bs-target="#modalTambah"
        class="btn btn-primary waves-effect waves-light">Tambah</button>
    </div>
  </div>
  <div class="card-datatable text-nowrap small">
    <form action="{{ route('barang.index') }}" method="GET">
      <div class="d-flex px-4 mb-4">
        <div class="col-5 ">
          <div class="form-floating form-floating-outline">
            <select type="text" id="statusFilter" name="statusFilter"
              class="form-select @error('statusFilter') is-invalid @enderror" value="{{ old('statusFilter') }}">
              <option value="">Filter By Status</option>
              <option value="Habis" {{ old('statusFilter')=='Habis' ? 'selected' : '' }}>Habis
              </option>
              <option value="Cukup" {{ old('statusFilter')=='Cukup' ? 'selected' : '' }}>Cukup
              </option>
              <option value="Hampir Habis" {{ old('statusFilter')=='Hampir Habis' ? 'selected' : '' }}>Hampir Habis
              </option>
            </select>
            <label>Status <span class="mr-4 mb-3" style="color: red">*</span></label>
          </div>
        </div>
        <button type="submit" class="ms-4 btn btn-sm btn-primary me-2">Apply Filter</button>
      </div>
    </form>

    <table class="datatables-ajax table table-bordered" id="tableData">
      <thead>
        <tr>
          <th>No.</th>
          <th class="text-center">Kode</th>
          <th class="text-center">Nama</th>
          <th class="text-center">Qty</th>
          <th class="text-center">Satuan</th>
          <th class="text-center">Min Qty</th>
          <th class="text-center">Status</th>
          <th class="text-center">Action</th>
        </tr>
      </thead>
      <tbody class="list">
        @foreach ($barang as $item)
        <tr role="row" class="odd ">
          <th scope="row" class="text-center">{{ $loop->iteration }}.</th>
          <td class="text-center">{{ $item->barang_code }}</td>
          <td class="text-center">{{ $item->barang_name }}</td>
          <td class="text-center">{{ $item->qty ?? 0 }}</td>
          <td class="text-center">{{ $item->satuan ?? '-' }}</td>
          <td class="text-center">{{ $item->min_qty ?? 0 }}</td>
          <td class="text-center">
            @if($item->status == "Cukup")
            <span class="badge rounded-pill  bg-label-success">Cukup</span>
            @elseif($item->status == 'Hampir Habis')
            <span class="badge rounded-pill  bg-label-warning">Hampir Habis</span>
            @elseif($item->status == 'Habis')
            <span class="badge rounded-pill  bg-label-danger">Habis</span>
            @endif
          </td>
          <td class="text-center">
            <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect editBtn"
              value="{{ $item->barang_id }}">
              <i class="ri-edit-box-line ri-20px"></i>
            </button>
            <button type="button" class="btn btn-sm btn-icon btn-text-danger rounded-pill waves-effect  deleteBtn"
              value="{{ $item->barang_id }}" onclick="deleteFunction({{ $item->barang_id }})">
              <i class="ri-delete-bin-7-line ri-20px"></i>
            </button>
            <form id="delete-form-{{ $item->barang_id }}" action="{{ route('barang.destroy', $item->barang_id) }}"
              method="post" style="display: none">
              @method('DELETE')
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </form>
            <button class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect dropdown-toggle hide-arrow"
              data-bs-toggle="dropdown"><i class="ri-more-2-line ri-20px"></i></button>
            <div class="dropdown-menu dropdown-menu-end m-0"><button class="dropdown-item"
                onclick="modalUbahQty({{ $item->barang_id }})"><i class="ri-error-warning-line me-2"></i><span>Ubah
                  Quantity</span></button>
              </button>
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
        <div class="text-center mb-6">
          <h4 class="mb-2" id="modalTitle">Tambah Data Barang</h4>
          <p class="mb-6">Lengkapi Form Berikut Ini</p>
        </div>
        <i class="mb-2"><span class="mt-2 mb-1 text-danger">(*)</span> Wajib Diisi, lengkapi form</i>
        <form action="{{ route('barang.store')}}" id="barangForm" class="row g-5 mt-3" method="POST"
          enctype="multipart/form-data">
          {{ csrf_field() }}
          <input type="hidden" name="barangId" id="barangId">
          <div class="col-12 col-md-6 mt-3">
            <div class="form-floating form-floating-outline">
              <input type="text" id="barang_code" name="barang_code"
                class="form-control @error('barang_code') is-invalid @enderror" value="{{ old('barang_code') }}"
                placeholder="Input Kode Barang">
              <label>Kode Barang <span class="mr-4 mb-3" style="color: red">*</span></label>
              @error('barang_code')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="col-12 col-md-6 mt-3">
            <div class="form-floating form-floating-outline">
              <input type="text" id="barang_name" name="barang_name"
                class="form-control @error('barang_name') is-invalid @enderror" value="{{ old('barang_name') }}"
                placeholder="Input Nama Barang">
              <label>Nama Barang <span class="mr-4 mb-3" style="color: red">*</span></label>
              @error('barang_name')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="col-12 col-md-6 mt-3">
            <div class="form-floating form-floating-outline">
              <select type="text" id="active" name="active" class="form-select @error('active') is-invalid @enderror"
                value="{{ old('active') }}">
                <option value="">Pilih Status</option>
                <option value="A" {{ old('status')=='A' ? 'selected' : '' }}>Aktif</option>
                <option value="N" {{ old('status')=='N' ? 'selected' : '' }}>Tidak
                  Aktif
                </option>
              </select>
              <label>Status <span class="mr-4 mb-3" style="color: red">*</span></label>
              @error('active')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="col-12 col-md-6 mt-3">
            <div class="form-floating form-floating-outline">
              <input type="text" id="satuan" name="satuan" class="form-control @error('satuan') is-invalid @enderror"
                value="{{ old('satuan') }}" placeholder="Input Satuan Barang">
              <label>Satuan <span class="mr-4 mb-3" style="color: red">*</span></label>
              @error('satuan')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="col-12 col-md-6 mt-3">
            <div class="form-floating form-floating-outline">
              <input type="number" id="qty" name="qty" class="form-control @error('qty') is-invalid @enderror"
                value="{{ old('qty') }}" placeholder="Input Qty Barang">
              <label>Quantity</label>
              <i class="small">Jika barang baru mohon diabaikan untuk field ini!</i>
              @error('qty')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="col-12 col-md-6 mt-3">
            <div class="form-floating form-floating-outline">
              <input type="number" id="min_qty" name="min_qty"
                class="form-control @error('min_qty') is-invalid @enderror" value="{{ old('min_qty') }}"
                placeholder="Input Minimum Qty Barang">
              <label>Min Qty</label>
              <i class="small">Minimal Qty berguna untuk notifikasi, jika barang akan habis!</i>
              @error('min_qty')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="col-12 col-md-12 mt-3" id="tempUpload">
            <div class="form-floating form-floating-outline">
              <input type="file" id="barang_photo" name="barang_photo" accept="image/png,image/jpeg"
                class="form-control @error('barang_photo') is-invalid @enderror" value="{{ old('barang_photo') }}"
                placeholder="Upload Photo Barang">
              <label>Photo Barang</label>
              @error('barang_photo')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <i class="small">Accept file on .png, .jpg. Maximum file size: 1 MB</i>
          </div>
          <div class="col-12 col-md-12 mt-3" id="tempPhoto">
            <div class="accordion mt-3">
              <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                  <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                    data-bs-target="#accordionOne" aria-expanded="false" aria-controls="accordionOne">
                    Klik untuk melihat Foto Barang
                  </button>
                </h2>

                <div id="accordionOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample" style="">
                  <div class="accordion-body">
                    <img src="" id="img_detail" width="300">
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
      <div class="mt-3 pt-5 col-12 text-center d-flex flex-wrap justify-content-center gap-4 row-gap-4" id="tempButton">
        <button type="submit" class="btn btn-primary waves-effect waves-light btnSubmit">Submit</button>
        <button type="reset" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="modal"
          aria-label="Close">Cancel</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade show " id="modalQty" aria-modal="true" role="dialog">
  <div class="modal-dialog modal-simple modal-enable-otp modal-dialog-centered">
    <div class="modal-content">
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      <div class="modal-body p-0">
        <div class="text-center mb-6">
          <h4 class="mb-2">Perubahan Quantity</h4>
          <p>Barang: <span id="qBarangNama"></span></p>
        </div>
        <div class="alert alert-danger mt-3 mb-2" role="alert">
          Tindakan Perubahan Qty akan mempengaruhi perhitungan stok Opname!
        </div>
        <form action="{{ route('barang.updateStok')}}" id="qbarangForm" class="row g-5 mt-3" method="POST"
          enctype="multipart/form-data">
          {{ csrf_field() }}
          <input type="hidden" name="qbarangId" id="qbarangId">
          <div class="col-12 col-md-12">
            <div class="form-floating form-floating-outline">
              <input type="number" id="qqty" name="qqty" class="form-control @error('qqty') is-invalid @enderror"
                value="{{ old('qqty') }}" placeholder="Edit Qty Barang">
              <label>Quantity</label>
              <i class="small">Hati - Hati terhadap perubahan Qty!</i>
              @error('qqty')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="col-12 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
            <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
            <button type="reset" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="modal"
              aria-label="Close">Cancel</button>
          </div>
          <input type="hidden">
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
    function modalUbahQty(itemId) {
        Swal.fire({
            title: 'Apakah Anda Yakin?',
            text: "Tindakan Perubahan Qty dapat mempengaruhi perhitungan stok opname!",
            icon: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Yakin!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                method: 'get',
                url: '/Master/barang/' + itemId,
                success: function (response) {
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
                        console.log(response)
                        $('#modalQty').modal('show')
                        $('#qbarangId').val(itemId);
                        $('#qBarangNama').html(response.barang_name)
                        $('input[name="qqty"]').val(response.qty);
                    }
                },
                error: function (response) {
                    console.log(response);
                }
            });

            }
        })
    }
    $(document).ready(function () {
        var button = $('#btn-tambah')

        button.on('click', function(){
            $('#modalTambah').modal('show')
        });

        var table = $('#tableData').DataTable();
        table.on('click', '.editBtn', function () {
            var id = $(this).val();
            $.ajax({
                method: 'get',
                url: '/Master/barang/' + id,
                success: function (response) {
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
                        $('#modalTitle').text('Edit Data Barang');
                        $('#barangId').val(id);
                        $('input[name="barang_code"]').val(response.barang_code);
                        $('input[name="barang_name"]').val(response.barang_name);
                        $('input[name="qty"]').val(response.qty);
                        $('input[name="min_qty"]').val(response.min_qty);
                        $('input[name="satuan"]').val(response.satuan);
                        $('#active').val(response.active);
                        console.log(response)
                        if(response.barang_photo){
                            $('#img_detail').attr('src', response.image_url);
                            $('#tempPhoto').show();
                        }

                        if (response.barang_id) {
                            let url = "{{ route('barang.update', ':id')}}"
                            url = url.replace(':id', id)
                            $('#barangForm').attr('action', url);
                            $('#barangForm').attr('method', 'POST');
                            $('#barangForm').append('<input type="hidden" name="_method" value="PUT">');
                        }
                        $('#qty').prop('disabled', true);

                    }
                },
                error: function (response) {
                    console.log(response);
                }
            });
        });

        $('#modalTambah').on('show.bs.modal', function (e) {
            $('#modalTitle').text('Tambah Data Barang');
            $('#tempUpload').show();
            $('.btnSubmit').show()
            $('#tempPhoto').hide();
            $('#barangForm').attr('action', "{{ route('barang.store') }}");
            $('#barangForm').attr('method', 'POST');
            $('#qty').prop('disabled', false);

            $('#barangForm').find('input:not([name="_token"]), select').val('');
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