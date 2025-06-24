<?php

namespace Modules\BarangPakaiHabis\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\BarangPakaiHabis\Database\factories\FormBarangPakaiHabisModelFactory;

class FormBarangPakaiHabisModel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'form_barang_pakai_habis';
    protected $fillable = [
        'namakegiatan',
        'email',
        'penanggungjawab',
        'tanggalpelaksanaan',
        'waktupelaksanaan',
        'lokasikegiatan',
        'setuju',
        'created_by',
        'updated_by'
    ];

    protected static function newFactory(): FormBarangPakaiHabisModelFactory
    {
        //return FormBarangPakaiHabisModelFactory::new();
    }
}
