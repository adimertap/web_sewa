<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seksi extends Model
{
  protected $table = "mst_seksi";

  protected $primaryKey = 'seksi_id';

  protected $fillable = [
    'seksi_kode',
    'seksi_name',
    'status'
  ];

  protected $hidden = [
    'updated_at',
    'created_at',
  ];

  public $timestamps = true;
}
