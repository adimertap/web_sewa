<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterSistemBayar extends Model
{
  use HasFactory;

  // Nama tabel di database
  protected $table = 'm_sistem_pembayaran';

  // Primary key tabel
  protected $primaryKey = 'sistem_id';

  // Kolom yang dapat diisi secara mass-assignment
  protected $fillable = [
    'sistem_pembayaran'
  ];

  // Kolom yang disembunyikan
  protected $hidden = [
    'created_at',
    'updated_at',
  ];

  // Timestamps
  public $timestamps = true;
}
