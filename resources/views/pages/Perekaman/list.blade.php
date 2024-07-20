@extends('layouts/layoutMaster')

@section('title', 'Perekaman')

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

{{-- <div class="filter">
  <form action="{{ route('transaksi.index') }}" method="GET">
    <div class="card mb-3">
      <div class="card-header">
        Filter
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-4">
            <div class="form-floating form-floating-outline">
              <select type="text" id="jenisTransaksi" name="jenisTransaksi"
                class="form-select @error('jenisTransaksi') is-invalid @enderror" value="{{ old('jenisTransaksi') }}">
                <option value="">Filter By Status</option>
                <option value="Masuk" {{ old('jenisTransaksi')=='Masuk' ? 'selected' : '' }}>Barang
                  Masuk
                </option>
                <option value="Keluar" {{ old('jenisTransaksi')=='Keluar' ? 'selected' : '' }}>Barang
                  Keluar
                </option>
              </select>
              <label>Jenis <span class="mr-4 mb-3" style="color: red">*</span></label>
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
        <div class="d-flex justify-content-end mt-4">
          <button type="submit" class="btn btn-sm btn-primary me-2">Apply</button>
          <a href="{{ route('transaksi.index') }}" type="button" class="btn btn-sm btn-danger">Reset</a>

        </div>
      </div>
    </div>
  </form>
</div> --}}



<div class="card">
  <div class="card-header p-3">
    <div class="d-flex justify-content-between">
      <div class="nav-align-top">
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item" role="presentation">
            <button type="button" class="nav-link active waves-effect" role="tab" data-bs-toggle="tab"
              data-bs-target="#navs-top-home" aria-controls="navs-top-home" aria-selected="true">Perekaman
              Masuk</button>
          </li>
          {{-- <li class="nav-item" role="presentation">
            <button type="button" class="nav-link waves-effect" role="tab" data-bs-toggle="tab"
              data-bs-target="#navs-top-profile" aria-controls="navs-top-profile" aria-selected="false"
              tabindex="-1">Perekaman Masuk</button>
          </li>
          <li class="nav-item" role="presentation">
            <button type="button" class="nav-link waves-effect" role="tab" data-bs-toggle="tab"
              data-bs-target="#navs-top-messages" aria-controls="navs-top-messages" aria-selected="false"
              tabindex="-1">Perekaman Keluar</button>
          </li> --}}
          <span class="tab-slider" style="left: 0px; width: 90.2344px; bottom: 0px;"></span>
        </ul>
      </div>
      <a href="{{ route('perekaman.create') }}" {{-- onclick="tambah()" --}} type="button" id="btn-tambah"
        class="btn btn-primary waves-effect waves-light">Tambah</a>
    </div>

  </div>
  <div class="card-datatable text-nowrap">
    <div class="tab-content p-0">
      <div class="tab-pane fade show active" id="navs-top-home" role="tabpanel">
        <table class="datatables-ajax table table-bordered small" id="tableData">
          <thead>
            <tr>
              <th>No.</th>
              <th class="text-center">Jenis</th>
              <th class="text-center">Kode</th>
              <th class="text-center">Tanggal</th>
              <th class="text-center">Total Barang</th>
              <th class="text-center">Status</th>
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody class="list">
            @foreach ($tr as $item)
            <tr role="row" class="odd ">
              <th scope="row" class="text-center">{{ $loop->iteration }}.</th>
              <th scope="row" class="text-center small">BARANG {{ $item->jenis_transaksi }}</th>

              <td class="text-center">
                <a href="{{ route('perekaman.show', $item->transaksi_id) }}" class="text-primary "><u>{{
                    $item->transaksi_code }}</u> </a>
              </td>
              <td class="text-center">{{ \Carbon\Carbon::parse($item->transaksi_date)->format('d F Y') }}
              </td>
              <td class="text-center">{{ $item->total_qty ?? 0 }}</td>
              <td class="text-center">
                @if($item->transaksi_status == "Pending")
                <button type="button" class="btn btn-xs btn-primary rounded-pill waves-effect confirmBtn"
                  value="{{ $item->transaksi_id }}" onclick="confirmFunction({{ $item->transaksi_id }})">
                  Click to Confirm
                </button>
                <form id="confirm-form-{{ $item->transaksi_id }}"
                  action="{{ route('perekaman.confirm', $item->transaksi_id) }}" method="post" style="display: none">
                  @method('PUT')
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
                @elseif($item->transaksi_status == 'Selesai')
                <span class="badge rounded-pill  bg-label-success">Done</span>
                @endif
              </td>
              <td class="text-center">
                @if($item->transaksi_status == 'Pending' || $item->transaksi_status == 'Rejcet')
                <a href="{{ route('perekaman.edit', $item->transaksi_id) }}" type="button"
                  class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect editBtn"
                  value="{{ $item->transaksi_id }}">
                  <i class="ri-edit-box-line ri-20px"></i>
                </a>
                <button type="button" class="btn btn-sm btn-icon btn-text-danger rounded-pill waves-effect  deleteBtn"
                  value="{{ $item->transaksi_id }}" onclick="deleteFunction({{ $item->transaksi_id }})">
                  <i class="ri-delete-bin-7-line ri-20px"></i>
                </button>
                <form id="delete-form-{{ $item->transaksi_id }}"
                  action="{{ route('perekaman.destroy', $item->transaksi_id) }}" method="post" style="display: none">
                  @method('DELETE')
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
                @endif

                <a href="{{ route('perekaman.cetak', $item->transaksi_id) }}" type="button" target="_blank"
                  class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect  cetakBtn">
                  <i class="ri-printer-line ri-20px"></i>
                </a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      {{-- <div class="tab-pane fade" id="navs-top-profile" role="tabpanel">
        <table class="datatables-ajax table table-bordered small" id="tableDataMasuk">
          <thead>
            <tr>
              <th>No.</th>
              <th class="text-center">Jenis</th>
              <th class="text-center">Kode</th>
              <th class="text-center">Tanggal</th>
              <th class="text-center">Total Barang</th>
              <th class="text-center">Status</th>
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody class="list">
            @foreach ($tr_masuk as $item)
            <tr role="row" class="odd ">
              <th scope="row" class="text-center">{{ $loop->iteration }}.</th>
              <th scope="row" class="text-center">BARANG {{ $item->jenis_transaksi }}</th>

              <td class="text-center">
                <a href="{{ route('perekaman.show', $item->transaksi_id) }}" class="text-primary "><u>{{
                    $item->transaksi_code }}</u> </a>
              </td>
              <td class="text-center">{{ \Carbon\Carbon::parse($item->transaksi_date)->format('d F Y') }}
              </td>
              <td class="text-center">{{ $item->total_qty ?? 0 }}</td>
              <td class="text-center">
                @if($item->transaksi_status == "Pending")
                <button type="button" class="btn btn-xs btn-primary rounded-pill waves-effect confirmBtn"
                  value="{{ $item->transaksi_id }}" onclick="confirmFunction({{ $item->transaksi_id }})">
                  Click to Confirm
                </button>
                <form id="confirm-form-{{ $item->transaksi_id }}"
                  action="{{ route('perekaman.confirm', $item->transaksi_id) }}" method="post" style="display: none">
                  @method('PUT')
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
                @elseif($item->transaksi_status == 'Selesai')
                <span class="badge rounded-pill  bg-label-success">Done</span>
                @endif
              </td>
              <td class="text-center">
                @if($item->transaksi_status == 'Pending' || $item->transaksi_status == 'Rejcet')
                <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect editBtn"
                  value="{{ $item->transaksi_id }}">
                  <i class="ri-edit-box-line ri-20px"></i>
                </button>
                <button type="button" class="btn btn-sm btn-icon btn-text-danger rounded-pill waves-effect  deleteBtn"
                  value="{{ $item->transaksi_id }}" onclick="deleteFunction({{ $item->transaksi_id }})">
                  <i class="ri-delete-bin-7-line ri-20px"></i>
                </button>
                <form id="delete-form-{{ $item->transaksi_id }}"
                  action="{{ route('perekaman.destroy', $item->transaksi_id) }}" method="post" style="display: none">
                  @method('DELETE')
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
                @endif

                <a href="{{ route('perekaman.cetak', $item->transaksi_id) }}" type="button" target="_blank"
                  class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect  cetakBtn">
                  <i class="ri-printer-line ri-20px"></i>
                </a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="tab-pane fade" id="navs-top-messages" role="tabpanel">
        <table class="datatables-ajax table table-bordered small" id="tableDataKeluar">
          <thead>
            <tr>
              <th>No.</th>
              <th class="text-center">Jenis</th>
              <th class="text-center">Kode</th>
              <th class="text-center">Tanggal</th>
              <th class="text-center">Total Barang</th>
              <th class="text-center">Status</th>
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody class="list">
            @foreach ($tr_keluar as $item)
            <tr role="row" class="odd ">
              <th scope="row" class="text-center">{{ $loop->iteration }}.</th>
              <th scope="row" class="text-center">BARANG {{ $item->jenis_transaksi }}</th>

              <td class="text-center">
                <a href="{{ route('perekaman.show', $item->transaksi_id) }}" class="text-primary "><u>{{
                    $item->transaksi_code }}</u> </a>
              </td>
              <td class="text-center">{{ \Carbon\Carbon::parse($item->transaksi_date)->format('d F Y') }}
              </td>
              <td class="text-center">{{ $item->total_qty ?? 0 }}</td>
              <td class="text-center">
                @if($item->transaksi_status == "Pending")
                <button type="button" class="btn btn-xs btn-primary rounded-pill waves-effect confirmBtn"
                  value="{{ $item->transaksi_id }}" onclick="confirmFunction({{ $item->transaksi_id }})">
                  Click to Confirm
                </button>
                <form id="confirm-form-{{ $item->transaksi_id }}"
                  action="{{ route('perekaman.confirm', $item->transaksi_id) }}" method="post" style="display: none">
                  @method('PUT')
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
                @elseif($item->transaksi_status == 'Selesai')
                <span class="badge rounded-pill  bg-label-success">Done</span>
                @endif
              </td>
              <td class="text-center">
                @if($item->transaksi_status == 'Pending' || $item->transaksi_status == 'Rejcet')
                <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect editBtn"
                  value="{{ $item->transaksi_id }}">
                  <i class="ri-edit-box-line ri-20px"></i>
                </button>
                <button type="button" class="btn btn-sm btn-icon btn-text-danger rounded-pill waves-effect  deleteBtn"
                  value="{{ $item->transaksi_id }}" onclick="deleteFunction({{ $item->transaksi_id }})">
                  <i class="ri-delete-bin-7-line ri-20px"></i>
                </button>
                <form id="delete-form-{{ $item->transaksi_id }}"
                  action="{{ route('perekaman.destroy', $item->transaksi_id) }}" method="post" style="display: none">
                  @method('DELETE')
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
                @endif

                <a href="{{ route('perekaman.cetak', $item->transaksi_id) }}" type="button" target="_blank"
                  class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect  cetakBtn">
                  <i class="ri-printer-line ri-20px"></i>
                </a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div> --}}
    </div>
  </div>
</div>

<div class="modal animate__animated animate__jackInTheBox" id="modalTambah" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-simple modal-dialog-centered">
    <div class="modal-content">
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      <div class="modal-body p-0">
        <div class="text-center mb-6">
          <h4 class="mb-2" id="modalTitle">Rekam Barang</h4>
          <p class="mb-6">Lengkapi Form Berikut Ini</p>
        </div>
        <i class="mb-4"><span class="mt-2 mb-3 text-danger">(*)</span> Wajib Diisi, lengkapi form</i>
        <form action="{{ route('perekaman.store')}}" id="rekamStore" class="row g-5 mt-3" method="POST"
          enctype="multipart/form-data">
          {{ csrf_field() }}
          <input type="hidden" name="rekamId" id="rekamId">

          <div class="col-12 col-md-6">
            <div class="form-floating form-floating-outline">
              <select type="text" id="barang_id" name="barang_id"
                class="form-select @error('barang_id') is-invalid @enderror" value="{{ old('barang_id') }}">
                <option value="">Pilih Barang</option> <!-- Default option without value -->
                @foreach ($barang as $item)
                <option value="{{ $item->barang_id }}" {{ old('barang_id')==$item->barang_id ?
                  'selected' :
                  '' }}>
                  Kode: {{ $item->barang_code }}, {{ $item->barang_name }}
                </option>
                @endforeach
              </select>
              <label for="modalEditUserEmail">Pilih Barang<span class="mr-4 mb-3" style="color: red">*</span></label>
              @error('seksi_id')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>


          <div class="col-12 col-md-6">
            <div class="form-floating form-floating-outline">
              <input type="text" id="barang_code" name="barang_code"
                class="form-control @error('barang_code') is-invalid @enderror" value="{{ old('barang_code') }}"
                placeholder="Input Kode Barang">
              <label>Pili Barang <span class="mr-4 mb-3" style="color: red">*</span></label>
              @error('barang_code')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="col-12 col-md-6">
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

          <div class="col-12 col-md-6">
            <div class="form-floating form-floating-outline">
              <input type="text" id="satuan" name="satuan" class="form-control @error('satuan') is-invalid @enderror"
                value="{{ old('satuan') }}" placeholder="Input Satuan Barang">
              <label>Satuan <span class="mr-4 mb-3" style="color: red">*</span></label>
              @error('satuan')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="col-12 col-md-6">
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
          <div class="col-12 col-md-6">
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
          <div class="col-12 col-md-12" id="tempUpload">
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
          <div class="col-12 col-md-12" id="tempPhoto">
            <div class="accordion mt-4">
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
      <div class="mt-5 pt-5 col-12 text-center d-flex flex-wrap justify-content-center gap-4 row-gap-4" id="tempButton">
        <button type="submit" class="btn btn-primary waves-effect waves-light btnSubmit">Submit</button>
        <button type="reset" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="modal"
          aria-label="Close">Cancel</button>
      </div>
      </form>
    </div>
  </div>
</div>
<script src="{{asset('assets/vendor/libs/jquery/jquery.js')}}"></script>
<script>
  function confirmFunction(itemId) {
        event.preventDefault();
        Swal.fire({
            title: 'Konfirmasi Perekaman',
            text: "Apakah Anda yakin untuk confirm dokumen perekaman ini?",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya! Confirm'
        }).then((result) => {
            if (result.isConfirmed) {
                event.preventDefault()
                document.getElementById(`confirm-form-${itemId}`).submit()
            }
        })
    }

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

    function tambah(){
        event.preventDefault();
        Swal.fire({
            title: "Jenis Transaksi",
            text: "Pilih Salah Satu Jenis Transaksi untuk melanjutkan!",
            icon: 'info',
            input: "select",
            inputOptions: {
                Masuk: "Barang Masuk",
                Keluar: "Barang Keluar",
            },
            inputPlaceholder: "Select Jenis Transaksi",
            showCancelButton: true,
            confirmButtonText: 'Save, Next!'
        }).then((result, text) => {
            if (result.isConfirmed) {
                event.preventDefault()
                var jenis = result.value

                $.ajax({
                    url: '/Transaksi/perekaman/create',
                    method: 'GET',
                    data: { jenis: jenis },
                    success: function(response) {
                        window.location.href = '/Transaksi/perekaman/create?jenis=' + jenis;
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            }
        })
    }


    $(document).ready(function () {
        var table = $('#tableData').DataTable();
        var table2 = $('#tableDataMasuk').DataTable();
        var table3 = $('#tableDataKeluar').DataTable();

    });



</script>



@endsection