<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaksi extends Model
{
  use HasFactory;

  // Nama tabel di database
  protected $table = 'tr_transaksi_header';

  // Primary key tabel
  protected $primaryKey = 'transaksi_id';

  // Kolom yang dapat diisi secara mass-assignment
  protected $fillable = [
    'jenis_id',
    'sistem_id',
    'lokasi',
    'nomor_perjanjian',
    'tanggal_perjanjian',
    'nomor_kode_barang',
    'nomor_register',
    'sertipikat',
    'jumlah_bidang_sewa_bagian',
    'luas_total_sertipikat',
    'luas_yang_disewa',
    'nama_pengguna',
    'nomor_telepon',
    'peruntukan',
    'nomor_tanggal_perjanjian',
    'jangka_waktu_kerjasama',
    'tahun_peninjauan_berikutnya',
    'jumlah_bidang_sewa_keseluruhan',
    'jatuh_tempo_pembangunan',
    'jatuh_tempo_pembayaran',

    'sistem_pembayaran',
    'sistem_pembayaran_ket',
    'jangka_waktu_mulai',
    'jangka_waktu_selesai',
    'besar_sewa',
    'besar_sewa_per',
    'kontribusi_awal',
    'kabupaten',
    'status',
    'keterangan',
    'created_by',
    'updated_by',

    // New
    'email',
    'NIK',
    'umur',
    'pekerjaan',
    'alamat',
    'nilai_per_pembayaran',
    'subtotal_kenaikan_harga'
  ];

  // Kolom yang disembunyikan
  protected $hidden = [
    'created_at',
    'updated_at',
  ];

  // Timestamps
  public $timestamps = true;
  public function Jenis(): BelongsTo
  {
    return $this->BelongsTo(JenisSewa::class, 'jenis_id', 'jenis_id');
  }
  public function SistemBayar(): BelongsTo
  {
    return $this->BelongsTo(MasterSistemBayar::class, 'sistem_id', 'sistem_id');
  }
  public function Pembayaran(): HasMany
  {
    return $this->hasMany(Pembayaran::class, 'transaksi_id', 'transaksi_id')->orderBy('pembayaran_tahun', 'asc');;
  }
  public function File(): HasMany
  {
    return $this->hasMany(TransaksiFile::class, 'transaksi_id', 'transaksi_id');
  }
  public function Kenaikan(): HasMany
  {
    return $this->hasMany(Kenaikan::class, 'transaksi_id', 'transaksi_id');
  }
  public function Nomor(): HasMany
  {
    return $this->hasMany(TransaksiNomor::class, 'transaksi_id', 'transaksi_id');
  }
}
