<?php

namespace Modules\Users\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FormHasilPeriksaModel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'form_hasil_periksa';
    protected $fillable = [
        'name',
        'file_attach',
        'users_receiver',
        'users_id',
        'created_by',
        'updated_by'
    ];

}
