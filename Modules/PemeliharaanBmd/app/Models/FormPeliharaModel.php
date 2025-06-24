<?php

namespace Modules\PemeliharaanBmd\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\PemeliharaanBmd\Database\factories\FormPeliharaModelFactory;

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

    protected static function newFactory(): FormPeliharaModelFactory
    {
        //return FormPeliharaModelFactory::new();
    }
}
