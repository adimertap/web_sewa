@extends('layouts/layoutMaster')
@section('title', 'Edit Perekaman')

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

<div class="card">
  <div class="card-body">
    <form action="{{ route('perekaman.store')}}" id="rekamStore" class="row g-5 mt-2" method="POST"
      enctype="multipart/form-data">
      {{ csrf_field() }}
      <div class="p-4 pt-3 pb-3 mb-1 mt-0">
        <h5 class="mb-0 mt-1">Edit Rekam Barang Masuk {{ $tr->transaksi_code }}</h5>
        <i class="mt-0 mb-3">Lengkapi Form Berikut Ini!</i>
        <hr>
        <div class="row">
          <div class="col-4">
            <div class="form-floating form-floating-outline">
              <select id="barang_id" name="barang_id" class="select2 form-select form-select-lg"
                value="{{ old('barang_id') }}" data-allow-clear="true">


                {{-- <select type="text" id="barang_id" name="barang_id"
                  class="form-select @error('barang_id') is-invalid @enderror" value="{{ old('barang_id') }}"> --}}
                  <option value="">Pilih Barang</option> <!-- Default option without value -->
                  @foreach ($barang as $item)
                  <option value="{{ $item->barang_id }}" {{ old('barang_id')==$item->barang_id ?
                    'selected' :
                    '' }}>{{ $item->barang_name }}
                  </option>
                  @endforeach
                </select>
                {{-- <label for="modalEditUserEmail">Pilih Barang<span class="mr-4 mb-3"
                    style="color: red">*</span></label> --}}
            </div>
            <i class="small">Tidak ada Barang? <a onclick="tambahBarang()" type="button" class="text-primary">Klik
                disini</a> untuk
              menambahkan </i>
          </div>
          <div class="col-2">
            <div class="form-floating form-floating-outline">
              <input type="text" id="barangCode" name="barangCode" class="form-control" placeholder="Automatic"
                readonly>
              <label>Kode Barang</label>
            </div>
          </div>
          <div class="col-2">
            <div class="form-floating form-floating-outline">
              <input type="number" id="qtyReal" name="qtyReal" class="form-control" placeholder="Automatic" readonly>
              <label>Qty Saat Ini </label>
            </div>
          </div>
          <div class="col-2">
            <div class="form-floating form-floating-outline">
              <input type="number" id="qty" name="qty" class="form-control @error('qty') is-invalid @enderror"
                value="{{ old('qty') }}" placeholder="Input Qty Barang">
              <label>Quantity <span class="mr-4 mb-3" style="color: red">*</span></label>
            </div>
          </div>
          <div class="col-2">
            <div class="form-floating form-floating-outline">
              <input type="text" id="satuan" name="satuan" class="form-control" placeholder="Automatic" readonly>
              <label>Satuan</label>
            </div>
          </div>
        </div>
        <div class="d-flex justify-content-end">
          <button type="button" class="btn btn-sm btn-primary" onclick="tambahData()">Tambah Data</button>
        </div>

      </div>
      <div class="border rounded-3 p-3 mt-1">
        <h5 class="mb-0 ms-4 mt-4">Detail Perekaman</h5>
        <i class="mt-0 ms-4 mb-3">Cek kembali barang yang telah Anda Rekam, klik submit untuk menyimpan</i>
        <hr>
        <div class="card-datatable text-nowrap ">
          <table class="datatables-ajax table table-bordered" id="tableData">
            <thead>
              <tr>
                <th>No.</th>
                <th class="text-center">Kode</th>
                <th class="text-center">Barang</th>
                <th class="text-center">Qty</th>
                <th class="text-center">Satuan</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody class="list">
              @foreach ($tr->Detail as $item)
              <tr role="row" class="odd ">
                <th scope="row">{{ $loop->iteration }}.</th>
                <td>{{ $item->Barang->barang_code }}</td>
                <td>{{ $item->Barang->barang_name }}</td>
                <td>{{ $item->qty }}</td>
                <td>{{ $item->Barang->satuan }}</td>
                <td>
                  <button class="btn rounded-pill btn-danger waves-effect waves-light btn-xs btn-delete"
                    onclick="deleteRow(this)">Delete</button>
                </td>

              </tr>

              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </form>
  </div>
  <div class="card-footer p-5">
    <hr>
    <div class="d-flex justify-content-between">
      <a href="{{ route('perekaman.index') }}" class="btn btn-sm btn-secondary">Back</a>
      <button onclick="submitFunction()" class="btn btn-sm btn-primary">Save Data</button>
    </div>
  </div>
</div>

<div class="modal fade animate__animated animate__jackInTheBox" id="modalTambahBarang" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-simple modal-dialog-centered">
    <div class="modal-content">
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      <div class="modal-body p-0">
        <div class="text-center mb-6">
          <h4 class="mb-2" id="modalTitle">Tambah Data Barang</h4>
          <p class="mb-6">Lengkapi Form Berikut Ini</p>
        </div>
        <i class="mb-4"><span class="mt-2 mb-3 text-danger">(*)</span> Wajib Diisi, lengkapi form</i>
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
              <input type="number" id="qty" name="qty" class="form-control" value="{{ old('qty') }}"
                placeholder="Input Qty Barang" disabled>
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
  function submitFunction() {
        Swal.fire({
            title: 'Are you sure?'
            , text: "Apakah Anda yakin untuk menyimpan data perekaman ini?"
            , icon: 'warning'
            , showCancelButton: true
            , confirmButtonColor: '#3085d6'
            , cancelButtonColor: '#d33'
            , confirmButtonText: 'Ya, Yakin!'
        }).then((result) => {
            if (result.isConfirmed) {
                submitData()
            }
        })
    }
    function submitData(){
        event.preventDefault()
        let jenis = $('#jenisTransaksi').html();
        var items = [];
            $('#tableData tbody tr').each(function() {
                var $row = $(this);
                var data = $('#tableData').DataTable().row($row).data(); // Get the data for the current row

                items.push({
                    barang_code: data[1],      // Assuming the barang code is in the second column
                    barang_name: data[2].trim(),      // Assuming the barang name is in the third column
                    qty: data[3],              // Assuming the quantity is in the fourth column
                    satuan: data[4]            // Assuming the satuan is in the fifth column
                });
            });

            $.ajax({
                url: '{{ route("perekaman.store") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    jenis: jenis,
                    items: items
                },
                success: function(response) {
                    localStorage.removeItem('tableData');
                    Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success',
                        customClass: {
                            confirmButton: 'btn btn-primary waves-effect waves-light'
                        },
                        buttonsStyling: false
                    });
                    window.location.href = response.redirect_url;
                },
                error: function(xhr) {
                    console.log(xhr)
                    Swal.fire({
                        title: 'Error!',
                        text: xhr.responseJSON.message,
                        icon: 'error',
                        customClass: {
                            confirmButton: 'btn btn-primary waves-effect waves-light'
                        },
                        buttonsStyling: false
                    });
                }
            });



    }

    function tambahBarang() {
        $('#modalTambahBarang').modal('show');
    }
    let iterationNumber = 0;
    function tambahData() {
        let jenis = $('#jenisTransaksi').html();
        let qty = $('#qty').val();

        if (qty == 0 || !qty) {
            Swal.fire({
                icon: "error"
                , title: "Oops..."
                , text: "Field Qty tidak boleh Kosong!"
            , });
            return;
        }

        if (jenis == 'Keluar') {
            // CHECK QTY TIDAK BOLEH MELEBIHI
            var qtyReals = $('#qtyReal').val();
            if (parseInt(qty) > parseInt(qtyReals)) {
                Swal.fire({
                    icon: "error"
                    , title: "Oops..."
                    , text: "Qty tidak boleh melebihi Qty Real!"
                , });
                $('#qty').val('');
                return;
            }
        }
        let barangName = $('#barang_id option:selected').text();
        let barangCode = $('#barangCode').val();
        let qtyReal = $('#qtyReal').val();
        let satuan = $('#satuan').val();
        var table = $('#tableData').DataTable();

        // Check if the row with the same barangName already exists
        let rowExists = false;
        table.rows().every(function() {
            let data = this.data();
            if (data[2] === barangName) { // Assuming barangName is in the 3rd column (index 2)
                rowExists = true;
                // Update the existing row
                this.data([
                    data[0], // Keep the iteration number
                    barangCode
                    , barangName
                    , qty
                    , satuan
                    , '<button class="btn rounded-pill btn-danger waves-effect waves-light btn-xs btn-delete" onclick="deleteRow(this)">Delete</button>'
                ]).draw(false);
                // saveTableData(table);
                return false; // Exit the loop
            }
        });

        if (!rowExists) {
            // Increment the iteration number only when adding a new row
            iterationNumber++;
            // Add the new data to the table
            table.row.add([
                iterationNumber
                , barangCode
                , barangName
                , qty
                , satuan
                , '<button class="btn rounded-pill btn-danger waves-effect waves-light btn-xs btn-delete" onclick="deleteRow(this)">Delete</button>'
            ]).draw(false);
            // saveTableData(table);
        }

        // Optionally, clear the form fields after adding the data
        $('#qty').val('');
        $('#barang_id').val('');
        // $('#barang_id').text('')
        $('#barangCode').val('');
        $('#qtyReal').val('');
        $('#satuan').val('');
    }

    function deleteRow(button) {
        var table = $('#tableData').DataTable();
        table.row($(button).parents('tr')).remove().draw(false);
        resetIterationNumbers(table);
        // saveTableData(table);
    }

    function resetIterationNumbers(table) {
        iterationNumber = 0;
        table.rows().every(function() {
            iterationNumber++;
            let data = this.data();
            data[0] = iterationNumber;
            this.data(data).draw(false);
        });
        // saveTableData(table);
    }

    function saveTableData(table) {
        let tableData = [];
        table.rows().every(function() {
            tableData.push(this.data());
        });
        localStorage.setItem('tableData', JSON.stringify(tableData));
    }

    function loadTableData(table) {
        let tableData = JSON.parse(localStorage.getItem('tableData'));
        if (tableData) {
            iterationNumber = tableData.length; // Set iterationNumber based on loaded data
            tableData.forEach(function(row) {
                table.row.add(row).draw(false);
            });
        }
    }


    $(document).ready(function() {
        var table = $('#tableData').DataTable();
        // loadTableData(table);
        $('#tambahDataButton').on('click', function() {
            tambahData();
        });
        $('#barang_id').change(function() {
            var barangId = $(this).val();
            if (barangId) {
                $.ajax({
                    url: '/Transaksi/perekaman/get/barang/' + barangId
                    , type: 'GET'
                    , dataType: 'json'
                    , success: function(response) {
                        if (response.message === 'Get Barang Success!') {
                            const datas = response.data
                            if (!datas.qty) {
                                $('#qtyReal').val(0)
                            } else {
                                $('#qtyReal').val(datas.qty)
                            }

                            $('#satuan').val(datas.satuan)
                            $('#barangCode').val(datas.barang_code)
                        } else {
                            console.log(response.message);
                        }
                    }
                    , error: function(xhr, status, error) {
                        console.log('Error: ' + error);
                        // Handle error here
                    }
                });
            }
        });
    });

    function deleteFunction(itemId) {
        Swal.fire({
            title: 'Are you sure?'
            , text: "You won't be able to revert this!"
            , icon: 'warning'
            , showCancelButton: true
            , confirmButtonColor: '#3085d6'
            , cancelButtonColor: '#d33'
            , confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                event.preventDefault()
                document.getElementById(`delete-form-${itemId}`).submit()
            }
        })
    }

</script>



@endsection
