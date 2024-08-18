@extends('layouts/layoutMaster')

@section('title', 'Tambah Transaksi')


@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/bs-stepper/bs-stepper.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/rateyo/rateyo.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/animate-css/animate.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}" />
<link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/bs-stepper/bs-stepper.js')}}"></script>
<script src="{{asset('assets/vendor/libs/rateyo/rateyo.js')}}"></script>
<script src="{{asset('assets/vendor/cleavejs/cleave.js')}}"></script>
<script src="{{asset('assets/vendor/@form-validation/popular.js')}}"></script>
<script src="{{asset('assets/vendor/@form-validation/bootstrap5.js')}}"></script>
<script src="{{asset('assets/vendor/@form-validation/auto-focus.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
<script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
@endsection

@section('page-style')
<link rel="stylesheet" href="{{asset('assets/vendor/scss/pages/wizard-ex-checkout.css')}}" />
@endsection

@section('page-script')
<script src="{{asset('assets/js/modal-add-new-address.js')}}"></script>
<script src="{{asset('assets/js/wizard-ex-checkout.js')}}"></script>
<script src="{{asset('assets/js/extended-ui-sweetalert2.js')}}"></script>
@endsection

@section('content')
@include('sweetalert::alert')

<!-- Checkout Wizard -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 gap-6">

  <div class="d-flex flex-column justify-content-center">
    <div class="d-flex align-items-center mb-1">
      <h5 class="mb-0">Tambah Bon Barang</h5>
      <span class="badge bg-label-primary me-2 ms-2 rounded-pill">New</span>
    </div>
    <p class="mb-4">Lengkapi Formulir Berikut Ini</p>
  </div>
  <div class="d-flex align-content-center flex-wrap gap-2">
    {{-- <button class="btn btn-outline-danger delete-order waves-effect">Back to List</button> --}}
  </div>
</div>
<div id="wizard-checkout" class="bs-stepper wizard-icons wizard-icons-example">
  <div class="bs-stepper-header m-auto border-0">
    <div class="step" data-target="#checkout-cart">
      <button type="button" class="step-trigger">
        <span class="bs-stepper-icon">
          <svg viewBox="0 0 58 54">
            <use xlink:href="{{asset('assets/svg/icons/wizard-checkout-address.svg#wizardCheckoutAddress')}}">
            </use>

          </svg>
        </span>
        <span class="bs-stepper-label">(1) Klik untuk Pilih Barang</span>
      </button>
    </div>
    <div class="line">
      <i class="ri-arrow-right-s-line"></i>
    </div>
    <div class="step" data-target="#checkout-address">
      <button type="button" class="step-trigger">
        <span class="bs-stepper-icon">
          <svg viewBox="0 0 54 54">
            <use xlink:href="{{asset('assets/svg/icons/wizard-checkout-cart.svg#wizardCart')}}"></use>
          </svg>
        </span>
        <span class="bs-stepper-label">(2) Keranjang Saya</span>
      </button>
    </div>
  </div>
  <div class="bs-stepper-content border-top rounded-0">
    <form id="wizard-checkout-form" id="formCreate">
      <div id="checkout-cart" class="content mb-5">
        @if(Auth::user()->role != 'User')
        <h6 class="mb-0">Pilih Seksi</h6>
        <div class="col-6 pt-3 pb-3 mb-3">
          <div class="form-floating form-floating-outline">
            <select id="seksi_id" name="seksi_id" class="select2 form-select form-select-lg"
              value="{{ old('seksi_id') }}" data-allow-clear="true">
              <option value=""></option> <!-- Default option without value -->
              @foreach ($seksi as $item)
              <option value="{{ $item->seksi_id }}" {{ old('seksi_id')==$item->seksi_id ?
                'selected' :'' }}>{{ $item->seksi_kode ?? '' }} - {{ $item->seksi_name }}
              </option>
              @endforeach
            </select>
          </div>
        </div>
        @else
        <h6 class="mb-0 text-muted">Seksi Anda</h6>
        <div class="col-6 pt-3 pb-3 mb-3">
          <div class="form-floating form-floating-outline">
            <select id="seksi_id" name="seksi_id" class="select2 form-select form-select-lg"
              value="{{ old('seksi_id') }}" data-allow-clear="true" disabled>
              <option value="{{ Auth::user()->seksi->seksi_id }}">{{ Auth::user()->seksi->seksi_name }}</option>
              <!-- Default option without value -->
              {{-- @foreach ($seksi as $item)
              <option value="{{ $item->seksi_id }}" {{ old('seksi_id')==$item->seksi_id ?
                'selected' :'' }}>{{ $item->seksi_kode ?? '' }} - {{ $item->seksi_name }}
              </option>
              @endforeach --}}
            </select>
          </div>
        </div>

        @endif

        <i class="mb-0">Pilih Barang yang akan di BON dengan cara klik tambah</i><br>
        <table class="datatables-ajax table" id="tableData">
          <thead>
            <tr>
              <th style="font-size: 12px!important">No.</th>
              <th class="text-center" style="font-size: 12px!important">Barang</th>
              <th class="text-center" style="font-size: 12px!important">Stok</th>
              <th class="text-center" style="font-size: 12px!important">Status</th>
              {{-- <th class="text-center" style="font-size: 12px!important">Input Qty</th> --}}
              <th class="text-center" style="font-size: 12px!important">Tambah</th>
            </tr>
          </thead>
          <tbody class="list">
            @foreach ($barang as $item)
            <tr role="row" class="odd ">
              <th scope="row" class="text-center">{{ $loop->iteration}}.</th>
              <td>
                <div class="d-flex justify-content-start align-items-center product-name">
                  <div class="avatar-wrapper me-3">
                    <div class="avatar rounded-3 bg-label-secondary"
                      style="width: 4rem!important;height: 4rem!important">
                      <img
                        src="{{ $item->barang_photo ? asset($item->barang_photo) : asset('storage/barang/null.png') }}"
                        alt="{{ $item->barang_name }}" class="rounded-2">
                    </div>
                  </div>
                  <div class="d-flex flex-column"><span class="text-nowrap text-heading fw-medium">{{
                      $item->barang_name }}</span><small class="text-truncate d-none d-sm-block">Kode Barang: {{
                      $item->barang_code
                      }}</small></div>
                </div>
              </td>
              <td class="text-center"><span class="qtyReal">{{ $item->qty }}</span> <span class="satuanBarang">{{
                  $item->satuan
                  }}</span> </td>
              <td class="text-center">
                @if($item->status == "Cukup")
                <span class="badge rounded-pill  bg-primary">In Stock</span>
                @elseif($item->status == 'Hampir Habis')
                <span class="badge rounded-pill  bg-warning">Hampir Habis</span>
                @endif
              </td>
              {{-- <td class="text-center">
                <div class="d-flex justify-content-center">
                  <button type="button"
                    class="btn btn-xs rounded-pill btn-outline-primary waves-effect waves-light me-2 minusButton">
                    <span class="tf-icons ri-subtract-line ri-16px"></span>
                  </button>

                  <input type="number" class="form-control me-2 form-control-sm qtyInput" style="width:80px"
                    placeholder="0" value="0">

                  <button type="button"
                    class="btn btn-xs rounded-pill btn-outline-primary waves-effect waves-light addButton">
                    <span class="tf-icons ri-add-line ri-16px"></span>
                  </button>
                </div>

              </td> --}}
              <td class="text-center">
                <button type="button"
                  onclick="modalTambah({{ $item->qty }},'{{ $item->barang_name }}', '{{ $item->barang_code }}', '{{ $item->satuan ?? '' }}', {{ $item->barang_id }})"
                  class="btn btn-sm rounded-pill btn-primary waves-effect waves-light">Tambah</button>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <div class="d-flex justify-content-end mt-5" style="margin-top:50px!important">
          <button id="nextButton" type="button" class="btn btn-primary btn-sm btn-next waves-effect waves-light">
            <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
            <i class="ri-arrow-right-line"></i>
          </button>
        </div>
      </div>

      <!-- Address -->
      <div id="checkout-address" class="content">
        @if(Auth::user()->role == 'User')
        <b class="ms-4">Permintaan dari : {{ Auth::user()->Seksi->seksi_name }}</b>

        @else
        <b class="ms-4">Permintaan dari : <span id="permintaanDari">Pilih Seksi Terlebih Dahulu</span></b>

        @endif
        <hr>
        <div class="col-12 col-lg-8 mx-auto text-center mb-4">
          <h4>Keranjang Saya! 📦 </h4>
          <p>Mohon dicek kembali keranjang Anda sebelum melakukan Checkout, </p>
        </div>
        <div class="table-responsive text-nowrap">
          <table class="datatables-ajax table" id="tableConfirm">
            <thead>
              <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Barang</th>
                <th>Qty</th>
                <th>Satuan</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="bodyConfirm">
            </tbody>
          </table>
        </div>
        <div class="d-flex justify-content-between mt-5" style="margin-top: 50px!important; padding: 30px!important">
          <button id="btnPrevious" class="btn btn-sm btn-secondary" type="button">Previous</button>
          <button onclick="submitFunction()" type="button" class="btn btn-sm btn-primary">Checkout</button>
        </div>
      </div>
    </form>
  </div>
</div>


<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-m modal-simple modal-dialog-centered">
    <div class="modal-content">
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      <div class="modal-body p-0">
        <form id="formModal" class="row g-5" method="POST">
          @csrf
          <div class="text-center mb-2">
            <h4 class="mb-1" id="modalTitle">Tambah Barang </h4>
            <p class="mb-4" id="modalNama"></p>
          </div>
          <input type="hidden" id="modalSatuan" name="satuan">
          <input type="hidden" id="modalId" name="idBarang">

          <div class="border p-2 mt-0">
            <div class="row">
              <div class="col-12 mt-2">
                <label>Nama Barang</label>
                <input type="text" id="modalBarang" name="nama" class="form-control form-control-sm" disabled />
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-8 mt-2">
                <label>Kode Barang</label>
                <input type="text" id="modalKode" name="kode" class="form-control form-control-sm" disabled />
              </div>
              <div class="col-4 mt-2">
                <label>Qty saat ini</label>
                <input type="number" id="modalQty" name="qty" class="form-control form-control-sm" disabled />
              </div>
            </div>
          </div>
          <div class="border p-2 mt-3">
            <i class="mt-1 mb-1">Input Qty Barang dibawah Ini </i>
            <div class="row mt-3 mb-4">
              <div class="col-12 mt-2">
                <label>Quantity Bon (Numeric) <span class="mr-4 mb-3" style="color: red">*</span></label>
                <input type="number" id="modalQtyKeluar" name="keluar" class="form-control form-control-sm" />
              </div>
            </div>
          </div>
          <div class="col-12 text-center d-flex flex-wrap justify-content-center gap-4 row-gap-4">
            <button type="button" class="btn btn-primary" onclick="tambahBarang()">Tambah</button>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" id="btn-close-modal"
              aria-label="Close">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>



<template id="template_delete_button">
  <button type="button" class="btn btn-sm rounded-pill btn-danger waves-effect waves-light removeButton">Delete</button>
  <button class="btn p-0" onclick="hapusdata(this)" type="button"><span class="text-700 fas fa-trash-alt"></span>
  </button>
</template>

<!--/ Checkout Wizard -->
{{-- <div id="bounceIcon" class="bounce-icon hidden">
  <svg width="50" height="50" viewBox="0 0 54 54">
    <use xlink:href="{{asset('assets/svg/icons/wizard-checkout-cart.svg#wizardCart')}}"></use>
  </svg>
</div> --}}
<!-- Add new address modal -->
@include('_partials/_modals/modal-add-new-address')
{{-- <style>
  @keyframes bounceToCart {
    0% {
      transform: translate(0, 0) scale(1);
    }

    50% {
      transform: translate(calc(var(--translate-x) / 2), calc(var(--translate-y) / 2)) scale(1.2);
    }

    100% {
      transform: translate(var(--translate-x), var(--translate-y)) scale(0);
    }
  }

  .bounce-icon {
    position: absolute;
    width: 50px;
    height: 50px;
    z-index: 9999;
    pointer-events: none;
    /* Prevent interaction */
  }

  .hidden {
    display: none;
  }
</style> --}}
<script src="{{asset('assets/vendor/libs/jquery/jquery.js')}}"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var stepperElement = document.querySelector('.bs-stepper');
    var stepper = new Stepper(stepperElement);

    document.getElementById('nextButton').addEventListener('click', function() {
      stepper.next();
    });
    document.getElementById('btnPrevious').addEventListener('click', function() {
      stepper.to(1); // Go to the first step
    });
  });
  function tambahBarang() {
    const nama = $('#modalBarang').val().trim();
    const kode =  $('#modalKode').val();
    const barangId =  $('#modalId').val();
    const qty_actual =  parseInt($('#modalQty').val());
    const satuan =  $('#modalSatuan').val();
    const qty = parseInt($('#modalQtyKeluar').val());

    if(!qty || qty === '') {
      Swal.fire({
        icon: "error",
        title: "Qty Belum Diinput",
        text: `Anda Belum Menginput Qty`,
      });
      return;
    }

    if(qty > qty_actual) {
      Swal.fire({
        icon: "error",
        title: "Stok tidak cukup",
        text: `Qty tidak boleh melebihi Stok ${qty_actual} ${satuan}`,
      });
      return;
    }

    // Find the row in tableData by the nama
    $('#tableData tbody tr').each(function() {
        const rowNama = $(this).find('td .product-name span.text-heading').text().trim();
        if (rowNama === nama) {
            // Get the current qty value
            const currentQty = parseInt($(this).find('td .qtyReal').text());
            // Calculate the new qty
            const newQty = currentQty - qty;
            // Update the qty in tableData
            $(this).find('td .qtyReal').text(newQty);
            return false; // Break the loop
        }
    });

    var table = $('#tableConfirm').DataTable();
    var row = $(`#${nama}`).closest('tr');
    table.row(row).remove().draw();

    // DRAW DATATABLE
    $('#tableConfirm').DataTable().row.add([
      nama, kode, nama, qty, satuan, qty
    ]).draw();

    $('#btn-close-modal').click();
    clearForm()


    Swal.fire({
        title: "Good job!",
        text: "Berhasil menambahkan barang ke keranjang",
        timer: 2000,
        showCancelButton: false,
        showDenyButton: false,
        showConfirmButton: false,
        icon: "success"
    });
}

  function clearForm()
  {
    $('#modalBarang').val('');
    $('#modalKode').val('');
    $('#modalId').val('');
    $('#modalQty').val('');
    $('#modalSatuan').val('');
    $('#modalQtyKeluar').val('');
  }


  function modalTambah(qty, barang, kode, satuan, id) {
    $('#modalTambah').modal('show')
    $('#modalNama').text(barang)
    $('#modalBarang').val(barang)
    $('#modalKode').val(kode)
    $('#modalSatuan').val(satuan)
    $('#modalQty').val(qty)
    $('#modalId').val(id)
   }

  function submitFunction() {
        Swal.fire({
            title: 'Are you sure?'
            , text: "Apakah Anda yakin untuk checkout bon barang ini?"
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
        event.preventDefault();
        var seksi_selected = $('#seksi_id').val()
        if(!seksi_selected || seksi_selected == ""){
          Swal.fire({
            icon: "error",
            title: "Seksi belum Dipilih",
            text: `Anda Belum Memilih Seksi, Pastikan Seksi terpilih pada dropdown`,
            showConfirmButton: false,
            timer: 2000
          });
          return;
        }

        var items = [];
        $('#tableConfirm tbody tr').each(function() {
            var $row = $(this);
            var barangCode = $row.find('td:eq(1)').text().trim();
            var barangName = $row.find('td:eq(2)').text().trim();
            var qty = parseInt($row.find('td:eq(3)').text().trim());
            var satuan = $row.find('td:eq(4)').text().trim();

            items.push({
                barang_name: barangName,
                barang_code: barangCode,
                qty: qty
            });
        });
        $.ajax({
            url: '{{ route("transaksi.store") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                seksi:seksi_selected,
                items: items
            },
            success: function(response) {
              console.log(response)
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

    $(document).ready(function () {
      $('#seksi_id').on('change', function() {
      var selectedOptionText = $(this).find('option:selected').text();
      var permintaanDari = selectedOptionText ? selectedOptionText : 'Pilih Seksi Terlebih Dahulu';

      $('#permintaanDari').text(permintaanDari);
    });
        var template = $('#template_delete_button').html()
        $('#tableConfirm').DataTable({
            "paging": false
            , "ordering": false
            , "info": false
            , "searching": false
            , "columnDefs": [{
                    "targets": -1
                    , "data": null
                    , "defaultContent": template
                }
                , {
                    "targets": 0
                    , "data": null
                    , 'render': function(data, type, row, meta) {
                        return meta.row + 1
                    }
                }
            ]
        });



        // function animateIconToCart(startElement) {
        //     var $icon = $('#bounceIcon');
        //     var $cartStep = $('[data-target="#checkout-address"] .step-trigger');

        //     // Ensure startElement is defined and log the elements
        //     if (!startElement || !startElement.length) {
        //         console.error('startElement is not defined or empty');
        //         return;
        //     }

        //     // Get the start and end positions
        //     var startPosition = startElement.offset();
        //     var endPosition = $cartStep.offset();
        //     var iconSize = $icon.width() / 2;

        //     // Calculate translate distances
        //     var translateX = endPosition.left - startPosition.left - iconSize;
        //     var translateY = endPosition.top - startPosition.top - iconSize;

        //     // Set custom properties for the animation
        //     $icon.css({
        //         '--translate-x': `${translateX}px`,
        //         '--translate-y': `${translateY}px`,
        //         top: startPosition.top + 'px',
        //         left: startPosition.left + 'px'
        //     });

        //     // Show the icon and start the animation
        //     $icon.removeClass('hidden');
        //     $icon.css({
        //         animation: 'bounceToCart 1s forwards'
        //     });

        //     // Hide the icon after the animation
        //     setTimeout(function() {
        //         $icon.addClass('hidden');
        //         $icon.css({
        //             animation: 'none'
        //         });
        //     }, 2000);
        //  }


    $('.addButton').click(function() {
        var $input = $(this).siblings('.qtyInput');
        var $button = $(this);
        var $row = $(this).closest('tr');
        var maxQty = parseInt($row.find('.qtyReal').text());
        var value = parseInt($input.val());

        if (value < maxQty) {
            $input.val(value + 1);
        } else {
            $button.prop('disabled', true); // Disable the button
        }
    });

    // Ensure the "Add" button is enabled when input value changes
    $('.qtyInput').on('input', function() {
        var $button = $(this).siblings('.addButton');
        var $row = $(this).closest('tr');
        var maxQty = parseInt($row.find('.qtyReal').text());
        var value = parseInt($(this).val());

        if (value > maxQty) {
            $(this).val(maxQty); // Set input value to maxQty
        } else if (value < 0) {
            $(this).val(0); // Set input value to 0 if it's less than 0
        }

        if (value < maxQty) {
            $button.prop('disabled', false); // Enable the button
        } else {
            $button.prop('disabled', true); // Disable the button if maxQty reached
        }
    });


    $('.minusButton').click(function() {
        var $button = $(this).siblings('.addButton');
        $button.prop('disabled', false);

        var $input = $(this).siblings('.qtyInput');
        var value = parseInt($input.val());
        if (value > 0) {
            $input.val(value - 1);
        }
    });

    // Initialize DataTables
    var tableData = $('#tableData').DataTable();
    var tableConfirm = $('#tableConfirm').DataTable();

    // Handle "Tambah" button click
    $('.tambahButton').click(function() {
        var $button = $(this);
        var $row = $(this).closest('tr');
        var barangName = $row.find('.product-name span').text();
        var barangCode = $row.find('.product-name small').text().replace('Kode Barang: ', '');
        var qty = parseInt($row.find('.qtyInput').val());
        var satuan = $row.find('.satuanBarang').text();
        var qtyReal = $row.find('.qtyReal').text();

        // Reset the input value to 0
        $row.find('.qtyInput').val(0);

        if(qty == 0){
            Swal.fire({
                    title: 'Warning!',
                    text: 'Qty tidak boleh 0!',
                    icon: 'warning',
                    customClass: {
                    confirmButton: 'btn btn-primary waves-effect waves-light'
                    },
                    buttonsStyling: false
                })
                return;
        }

        if(qty > qtyReal){
            Swal.fire({
                    title: 'Warning!',
                    text: `Stok Tidak Cukup!, Stok hanya ${qtyReal}`,
                    icon: 'warning',
                    customClass: {
                    confirmButton: 'btn btn-primary waves-effect waves-light'
                    },
                    buttonsStyling: false
                })
                return;
        }
        animateIconToCart($button);
        // Create the formatted barangName
        var formattedBarangName = '<div class="d-flex justify-content-start align-items-center product-name">' +
                                  '<div class="d-flex flex-column"><span class="text-nowrap text-heading fw-medium">' + barangName + '</span>' +
                                  '<small class="text-truncate d-none d-sm-block">Kode Barang: ' + barangCode + '</small></div></div>';

        // Check if the row already exists in tableConfirm
        var exists = false;
        tableConfirm.rows().every(function() {
            var data = this.data();
            if (data[0].includes(barangName)) {
                var existingQty = parseInt($(data[1]).text());
                var newQty = existingQty + qty;
                this.data([
                    formattedBarangName,
                    '<td class="text-center">' + newQty + '</td>',
                    '<td class="text-center">' + satuan + '</td>',
                    '<td class="text-center"><button class="btn btn-xs rounded-pill btn-danger removeButton">Hapus</button></td>'
                ]).draw(false);
                exists = true;
                return false;
            }
        });

        // If the row doesn't exist, add a new row
        if (!exists) {
            tableConfirm.row.add([
                formattedBarangName,
                '<td class="text-center">' + qty + '</td>',
                '<td class="text-center">' + satuan + '</td>',
                '<td class="text-center"><button class="btn btn-xs rounded-pill btn-danger removeButton">Hapus</button></td>'
            ]).draw(false);
        }

        // Optionally remove the row from the original table
        // tableData.row($row).remove().draw(false);
        Swal.fire({
            title: 'Success!',
            text: 'Sukses, Cek Keranjang Anda!',
            icon: 'success',
            timer: 1500,
            customClass: {
            confirmButton: 'btn btn-primary waves-effect waves-light'
            },

            buttonsStyling: false
        });
    });

    // Handle "Remove" button click
    $('#tableConfirm tbody').on('click', '.removeButton', function() {
        var row = $(this).closest('tr');
        var rowData = tableConfirm.row(row).data();
        var nama = rowData[0]; // Assuming the name is in the first column
        var qty = parseInt(rowData[3]); // Assuming the qty is in the third column

        // Increase the qty in tableData
        $('#tableData tbody tr').each(function() {
            var rowNama = $(this).find('td .product-name span.text-heading').text().trim();
            if (rowNama === nama) {
                // Get the current qty value
                var currentQty = parseInt($(this).find('td .qtyReal').text());
                // Calculate the new qty
                var newQty = currentQty + qty;
                // Update the qty in tableData
                $(this).find('td .qtyReal').text(newQty);
                return false; // Break the loop
            }
        });

        // Remove the row from tableConfirm
        tableConfirm.row(row).remove().draw(false);

        Swal.fire({
            title: 'Success!',
            text: 'Sukses Hapus Barang!',
            icon: 'success',
            timer: 1500,
            customClass: {
                confirmButton: 'btn btn-primary waves-effect waves-light'
            },
            buttonsStyling: false
        });
    });
});



</script>

@endsection