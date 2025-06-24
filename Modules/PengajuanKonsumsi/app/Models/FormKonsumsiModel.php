<?php

namespace Modules\PengajuanKonsumsi\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\PengajuanKonsumsi\Database\factories\FormKonsumsiModelFactory;

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

    protected static function newFactory(): FormKonsumsiModelFactory
    {
        //return FormKonsumsiModelFactory::new();
    }
}
