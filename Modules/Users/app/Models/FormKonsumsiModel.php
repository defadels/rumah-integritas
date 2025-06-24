<?php

namespace Modules\Users\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FormKonsumsiModel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'form_konsumsi';
    protected $fillable = [
        'name',
        'email',
        'judul_rapat',
        'waktu',
        'jml_konsumsi',
        'setuju',
        'created_by',
        'updated_by'
    ];

}
