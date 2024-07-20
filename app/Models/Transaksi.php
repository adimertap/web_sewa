<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaksi extends Model
{
  protected $table = "tr_transaksi";

  protected $primaryKey = 'transaksi_id';

  protected $fillable = [
    'transaksi_code',
    'transaksi_status',
    'transaksi_date',
    'transaksi_tyoe',
    'jenis_transaksi',
    'user_id',
    'user_proses_id',
    'total_qty',
    'approved_by',
    'seksi_kode',
    'seksi_id'
  ];

  protected $hidden = [
    'updated_at',
    'created_at',
  ];

  public $timestamps = true;

  public function User(): BelongsTo
  {
    return $this->belongsTo(User::class, 'user_id', 'id');
  }

  public function Seksi(): BelongsTo
  {
    return $this->belongsTo(Seksi::class, 'seksi_id', 'seksi_id');
  }

  public function ApprovedBy(): BelongsTo
  {
    return $this->belongsTo(User::class, 'approved_by', 'id');
  }

  public function Detail(): HasMany
  {
    return $this->hasMany(DetailTransaksi::class, 'transaksi_id', 'transaksi_id');
  }
}
