<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kenaikan extends Model
{
  use HasFactory;

  // Nama tabel di database
  protected $table = 'tr_transaksi_kenaikan';

  // Primary key tabel
  protected $primaryKey = 'kenaikan_id';

  // Kolom yang dapat diisi secara mass-assignment
  protected $fillable = [
    'transaksi_id',
    'tahun_ke',
    'besaran',
    'status',
    'created_by',
    'updated_by',
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
