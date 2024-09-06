<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Saran extends Model
{
  protected $table = "saran";

  protected $primaryKey = 'saran_id';

  protected $fillable = [
    'saran',
    'user_id',
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
}
