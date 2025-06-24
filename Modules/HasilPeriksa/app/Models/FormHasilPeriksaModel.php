<?php

namespace Modules\HasilPeriksa\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\HasilPeriksa\Database\factories\FormHasilPeriksaModelFactory;

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

    protected static function newFactory(): FormHasilPeriksaModelFactory
    {
        //return FormHasilPeriksaModelFactory::new();
    }
}
