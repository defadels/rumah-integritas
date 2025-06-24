<?php

namespace Modules\Users\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JenisPemeliharaanModel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'jenis_pemeliharaan';
    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = ['id','name','guard_name','created_by','created_at','updated_by','updated_at'];


}
