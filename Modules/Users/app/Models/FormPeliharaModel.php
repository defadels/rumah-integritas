<?php

namespace Modules\Users\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FormPeliharaModel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'form_pelihara';
    protected $fillable = [
        'name',
        'email',
        'jenis_pelihara',
        'jenis_keluhan',
        'sub_bag',
        'setuju',
        'created_by',
        'updated_by'
    ];

}
