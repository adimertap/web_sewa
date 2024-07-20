<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailTransaksi extends Model
{
    protected $table = "det_transaksi";

    protected $primaryKey = 'detail_id';

    protected $fillable = [
        'transaksi_id',
        'barang_id',
        'qty'
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
    ];

    public $timestamps = true;

    public function Barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'barang_id', 'barang_id');
    }

    public function Transaksi(): BelongsTo
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id', 'transaksi_id');
    }
}
