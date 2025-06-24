<?php

namespace Modules\Dapodik\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DapodikGuruModel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'dapodik_guru';
    protected $dates = ['tgl_lahir','tgl_cpns','tmt_pengangkatan','tmt_pangkat','created_at', 'updated_at'];
    protected $fillable = ['id','nama_lengkap','nik','nuptk','nip','jk','no_sk','tmp_lahir','tgl_lahir','status_tugas','tmp_tugas','npsn',
        'kecamatan','kabupaten','kecamatan_id','kabupaten_id','provinsi_id','no_hp','sk_cpns','tgl_cpns','sk_pengangkatan',
        'tmt_pengangkatan','jenis_ptk','pendidikan','bidang_studi_kependidikan','bidang_studi_sertifikasi','status_kepegawaian',
        'pangkat_gol','tmt_pangkat','masa_kerja_tahun','masa_kerja_bulan','mata_pelajaran','jam_mengajar','jabatan_kepsek','created_by','created_at','updated_by','updated_at'];

    public function scopeFilter($query, $request)
    {
        if ($request->has('s')) {
            $query->where(function($query) use ($request) {
                $query->where('dapodik_guru.nama_lengkap', 'like', '%'.$request->get('s').'%')
                    ->OrWhere('dapodik_guru.nik', 'like', '%'.$request->get('s').'%')
                    ->OrWhere('dapodik_guru.nip', 'like', '%'.$request->get('s').'%')
                    ->OrWhere('dapodik_guru.no_hp', 'like', '%'.$request->get('s').'%');
            });
        }
        return $query;
    }

    public function user_created(): BelongsTo
    {
        return $this->belongsTo('Modules\Users\Models\UsersModel', 'created_by');
    }

    public function user_updated(): BelongsTo
    {
        return $this->belongsTo('Modules\Users\Models\UsersModel', 'updated_by');
    }

    protected function casts(): array
    {
        return [
            'tgl_lahir' => 'date',
            'tgl_cpns' => 'date',
            'tmt_pengangkatan' => 'date',
            'tmt_pangkat' => 'date',
        ];
    }


}
