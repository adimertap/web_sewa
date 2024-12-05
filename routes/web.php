<?php

use App\Http\Controllers\apps\InvoiceAdd;
use App\Http\Controllers\apps\InvoiceEdit;
use App\Http\Controllers\apps\InvoiceList;
use App\Http\Controllers\apps\InvoicePreview;
use App\Http\Controllers\apps\InvoicePrint;
use App\Http\Controllers\apps\UserList;
use App\Http\Controllers\apps\UserViewAccount;
use App\Http\Controllers\apps\UserViewBilling;
use App\Http\Controllers\apps\UserViewSecurity;
use App\Http\Controllers\authentications\TwoStepsBasic;
use App\Http\Controllers\authentications\TwoStepsCover;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\form_elements\BasicInput;
use App\Http\Controllers\form_elements\CustomOptions;
use App\Http\Controllers\form_elements\Editors;
use App\Http\Controllers\form_elements\Extras;
use App\Http\Controllers\form_elements\FileUpload;
use App\Http\Controllers\form_elements\InputGroups;
use App\Http\Controllers\form_elements\Picker;
use App\Http\Controllers\form_elements\Selects;
use App\Http\Controllers\form_elements\Sliders;
use App\Http\Controllers\form_elements\Switches;
use App\Http\Controllers\form_layouts\HorizontalForm;
use App\Http\Controllers\form_layouts\StickyActions;
use App\Http\Controllers\form_layouts\VerticalForm;
use App\Http\Controllers\form_validation\Validation;
use App\Http\Controllers\JenisSewaController;
use App\Http\Controllers\LaporanBulanan;
use App\Http\Controllers\OpnameController;
use App\Http\Controllers\pages\UserProfile;
use App\Http\Controllers\PerekamanController;
use App\Http\Controllers\SaranController;
use App\Http\Controllers\SeksiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\form_wizard\Numbered as FormWizardNumbered;
use App\Http\Controllers\form_wizard\Icons as FormWizardIcons;
use App\Http\Controllers\LaporanSewaController;
use App\Http\Controllers\modal\ModalExample;
use App\Http\Controllers\SewaController;
use App\Http\Controllers\SistemBayarController;
use App\Http\Controllers\tables\Basic as TablesBasic;
use App\Http\Controllers\tables\DatatableBasic;
use App\Http\Controllers\tables\DatatableAdvanced;
use App\Http\Controllers\tables\DatatableExtensions;
use App\Http\Controllers\user_interface\Modals;
use App\Http\Controllers\user_interface\Offcanvas;
use App\Http\Controllers\user_interface\TabsPills;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::middleware('auth')->group(function () {
  Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');

  Route::get('/pages/profile-user', [UserProfile::class, 'index'])->name('pages-profile-user');
  // // form elements
  Route::get('/forms/basic-inputs', [BasicInput::class, 'index'])->name('forms-basic-inputs');
  Route::get('/forms/input-groups', [InputGroups::class, 'index'])->name('forms-input-groups');
  Route::get('/forms/custom-options', [CustomOptions::class, 'index'])->name('forms-custom-options');
  Route::get('/forms/editors', [Editors::class, 'index'])->name('forms-editors');
  Route::get('/forms/file-upload', [FileUpload::class, 'index'])->name('forms-file-upload');
  Route::get('/forms/pickers', [Picker::class, 'index'])->name('forms-pickers');
  Route::get('/forms/selects', [Selects::class, 'index'])->name('forms-selects');
  Route::get('/forms/sliders', [Sliders::class, 'index'])->name('forms-sliders');
  Route::get('/forms/switches', [Switches::class, 'index'])->name('forms-switches');
  Route::get('/forms/extras', [Extras::class, 'index'])->name('forms-extras');

  // form layouts
  Route::get('/form/layouts-vertical', [VerticalForm::class, 'index'])->name('form-layouts-vertical');
  Route::get('/form/layouts-horizontal', [HorizontalForm::class, 'index'])->name('form-layouts-horizontal');
  Route::get('/form/layouts-sticky', [StickyActions::class, 'index'])->name('form-layouts-sticky');

  // form wizards
  Route::get('/form/wizard-numbered', [FormWizardNumbered::class, 'index'])->name('form-wizard-numbered');
  Route::get('/form/wizard-icons', [FormWizardIcons::class, 'index'])->name('form-wizard-icons');
  Route::get('/form/validation', [Validation::class, 'index'])->name('form-validation');

  Route::get('/app/invoice/list', [InvoiceList::class, 'index'])->name('app-invoice-list');
  Route::get('/app/invoice/preview', [InvoicePreview::class, 'index'])->name('app-invoice-preview');
  Route::get('/app/invoice/print', [InvoicePrint::class, 'index'])->name('app-invoice-print');
  Route::get('/app/invoice/edit', [InvoiceEdit::class, 'index'])->name('app-invoice-edit');
  Route::get('/app/invoice/add', [InvoiceAdd::class, 'index'])->name('app-invoice-add');
  Route::get('/app/user/list', [UserList::class, 'index'])->name('app-user-list');
  Route::get('/app/user/view/account', [UserViewAccount::class, 'index'])->name('app-user-view-account');
  Route::get('/app/user/view/security', [UserViewSecurity::class, 'index'])->name('app-user-view-security');
  Route::get('/app/user/view/billing', [UserViewBilling::class, 'index'])->name('app-user-view-billing');


  Route::get('/tables/basic', [TableBasic::class, 'index'])->name('tables-basic');
  Route::get('/tables/datatables-basic', [DatatableBasic::class, 'index'])->name('tables-datatables-basic');
  Route::get('/tables/datatables-advanced', [DatatableAdvanced::class, 'index'])->name('tables-datatables-advanced');
  Route::get('/tables/datatables-extensions', [DatatableExtensions::class, 'index'])->name('tables-datatables-extensions');

  Route::get('/modal-examples', [ModalExample::class, 'index'])->name('modal-examples');
  Route::get('/ui/modals', [Modals::class, 'index'])->name('ui-modals');
  Route::get('/ui/offcanvas', [Offcanvas::class, 'index'])->name('ui-offcanvas');
  Route::get('/ui/tabs-pills', [TabsPills::class, 'index'])->name('ui-tabs-pills');

  Route::get('/auth/two-steps-basic', [TwoStepsBasic::class, 'index'])->name('auth-two-steps-basic');
  Route::get('/auth/two-steps-cover', [TwoStepsCover::class, 'index'])->name('auth-two-steps-cover');

  Route::get('/app/invoice/preview', [InvoicePreview::class, 'index'])->name('app-invoice-preview');

  Route::get('/app/user/view/account', [UserViewAccount::class, 'index'])->name('app-user-view-account');
  Route::get('/app/user/view/security', [UserViewSecurity::class, 'index'])->name('app-user-view-security');
  Route::get('/app/user/view/billing', [UserViewBilling::class, 'index'])->name('app-user-view-billing');




  Route::resource('sewa', SewaController::class)->parameters(['sewa' => 'id',]);
  Route::post('/sewa/pembayaran/{id}', [SewaController::class, 'TambahPembayaran'])->name('sewa.bayar');
  Route::post('/sewa/selesai/{id}', [SewaController::class, 'Selesai'])->name('sewa.selesai');

  Route::get('/sewa/print/{id}', [SewaController::class, 'PrintSewa'])->name('sewa.print');
  Route::delete('/sewa/delete/pembayaran/{id}', [SewaController::class, 'DeletePembayaran'])->name('sewa.bayar.delete');
  Route::post('/sewa/update/pembayaran', [SewaController::class, 'UpdatePembayaran'])->name('sewa.bayar.update');
  Route::post('/sewa/tambah/file', [SewaController::class, 'TambahFile'])->name('sewa.file.tambah');
  Route::delete('/sewa/file/{fileId}', [SewaController::class, 'DeleteFile'])->name('sewa.file.delete');
  Route::post('/sewa/kenaikan/{id}', [SewaController::class, 'TambahKenaikan'])->name('sewa.kenaikan.tambah');
  Route::post('/sewa/update/kenaikan', [SewaController::class, 'UpdateKenaikan'])->name('sewa.kenaikan.update');
  Route::delete('/sewa/delete/kenaikan/{id}', [SewaController::class, 'DeleteKenaikan'])->name('sewa.kenaikan.delete');

  Route::post('/sewa/nomor/{id}', [SewaController::class, 'TambahNomor'])->name('sewa.nomor.tambah');
  Route::post('/sewa/update/nomor', [SewaController::class, 'UpdateNomor'])->name('sewa.nomor.update');
  Route::delete('/sewa/delete/nomor/{id}', [SewaController::class, 'DeleteNomor'])->name('sewa.nomor.delete');


  Route::resource('laporan-sewa', LaporanSewaController::class)->parameters(['lp' => 'id',]);
  Route::post('/laporan-sewa/excel', [LaporanSewaController::class, 'Excel'])->name('laporan-sewa.excel');




  Route::prefix('Master')->group(function () {
    Route::resource('user', UserController::class)->parameters(['user' => 'id',]);
    Route::resource('jenis-sewa', JenisSewaController::class)->parameters(['sewa' => 'id',]);
    Route::resource('sistem-bayar', SistemBayarController::class)->parameters(['sistem' => 'id',]);


    Route::post('/user/password', [UserController::class, 'change_password'])->name('user-change-password');

    Route::resource('seksi', SeksiController::class)->parameters(['seksi' => 'id',]);
    Route::resource('barang', BarangController::class)->parameters(['barang' => 'id',]);
    Route::post('/barang/stok', [BarangController::class, 'updateStok'])->name('barang.updateStok');
  });

  Route::prefix('Transaksi')->group(function () {
    Route::resource('transaksi', TransaksiController::class)->parameters(['transaksi' => 'id',]);
    Route::put('/transaksi/approve/{id}', [TransaksiController::class, 'approve'])->name('transaksi.approve');
    Route::put('/transaksi/reject/{id}', [TransaksiController::class, 'reject'])->name('transaksi.reject');
    Route::put('/transaksi/selesai/{id}', [TransaksiController::class, 'selesai'])->name('transaksi.selesai');
    Route::get('/transaksi/cetak/{id}', [TransaksiController::class, 'cetak'])->name('transaksi.cetak');

    Route::resource('perekaman', PerekamanController::class)->parameters(['perekaman' => 'id',]);
    Route::get('/perekaman/get/barang/{id}', [PerekamanController::class, 'databarang'])->name('perekaman.get.barang');
    Route::put('/perekaman/confirm/{id}', [PerekamanController::class, 'confirm'])->name('perekaman.confirm');
    Route::get('/perekaman/cetak/{id}', [PerekamanController::class, 'cetak'])->name('perekaman.cetak');

    Route::resource('opname', OpnameController::class)->parameters(['opname' => 'id',]);
    Route::post('/reset/opname', [OpnameController::class, 'resetOpname'])->name('opname.reset');
    Route::post('/reset/stok', [OpnameController::class, 'resetStok'])->name('opname.reset.stok');
    Route::post('/reset/transaksi', [OpnameController::class, 'resetTransaksi'])->name('opname.reset.transaksi');
    Route::post('/opname/cetak', [OpnameController::class, 'cetak'])->name('opname.cetak');

    Route::resource('laporan-bulanan', LaporanBulanan::class)->parameters(['laporan' => 'id',]);
    Route::get('/laporan-bulanan/{month}/{year}/{seksi}', [LaporanBulanan::class, 'getDetail'])->name('laporan-bulanan.detail');
    Route::post('/laporan-bulanan/cetak', [LaporanBulanan::class, 'cetak'])->name('laporan-bulanan.cetak');
  });

  Route::resource('saran', SaranController::class)->parameters(['saran' => 'id',]);

  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
