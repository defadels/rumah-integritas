<?php

namespace Modules\KartuKendali\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\KartuKendali\Database\factories\FormKartuKendaliModelFactory;

class FormKartuKendaliModel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'form_kartu_kendali';
    protected $fillable = [
        'kode_sub',
        'sub_kegiatan',
        'sub_bidang',
        'pekerjaan',
        'rekanan',
        'pagu_dana',
        'spk_no',
        'bap_tgl',
        'bap_no',
        'bast_tgl',
        'bast_no',
        'bapem_tgl',
        'bapem_no',
        'spp_no',
        'spp_nilai',
        'sisa_anggaran',
        'keterangan',
        'created_by',
        'updated_by'
    ];

    protected static function newFactory(): FormKartuKendaliModelFactory
    {
        //return FormKartuKendaliModelFactory::new();
    }
}
