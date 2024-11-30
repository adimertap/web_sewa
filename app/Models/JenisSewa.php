<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisSewa extends Model
{
  use HasFactory;

  // Nama tabel di database
  protected $table = 'm_jenis_sewa';

  // Primary key tabel
  protected $primaryKey = 'jenis_id';

  // Kolom yang dapat diisi secara mass-assignment
  protected $fillable = [
    'jenis_nama',
    'active'
  ];

  // Kolom yang disembunyikan
  protected $hidden = [
    'created_at',
    'updated_at',
  ];

  // Timestamps
  public $timestamps = true;
}
