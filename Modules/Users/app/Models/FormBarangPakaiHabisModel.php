<?php

namespace Modules\Users\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FormBarangPakaiHabisModel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'form_barang_pakai_habis';
    protected $fillable = [
        'name',
        'email',
        'judul_rapat',
        'waktu',
        'jenis',
        'sub_bag',
        'jml',
        'setuju',
        'created_by',
        'updated_by'
    ];

}
