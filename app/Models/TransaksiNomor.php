<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransaksiNomor extends Model
{
  use HasFactory;

  // Nama tabel di database
  protected $table = 'tr_transaksi_nomor';

  // Primary key tabel
  protected $primaryKey = 'transaksi_nomor_id';

  // Kolom yang dapat diisi secara mass-assignment
  protected $fillable = [
    'transaksi_id',
    'nomor_perjanjian',
    'tanggal_perjanjian',
  ];

  // Kolom yang disembunyikan
  protected $hidden = [
    'created_at',
    'updated_at',
  ];

  // Timestamps
  public $timestamps = true;

  public function Transaksi(): BelongsTo
  {
    return $this->belongsTo(Transaksi::class, 'transaksi_id', 'transaksi_id');
  }
}
