<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
  protected $table = "mst_barang";

  protected $primaryKey = 'barang_id';

  protected $fillable = [
    'barang_code',
    'barang_name',
    'qty',
    'satuan',
    'barang_photo',
    'status',
    'min_qty',
    'active'
  ];

  protected $hidden = [
    'updated_at',
    'created_at',
  ];

  public $timestamps = true;
}
