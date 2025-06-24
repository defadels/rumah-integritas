<?php

namespace Modules\Dapodik\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DapodikSekolahWcModel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'dapodik_sekolah_wc';
    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = ['id','nama_sekolah','npsn','wc_guru_laki_baik','wc_guru_laki_rusak_ringan','wc_guru_laki_rusak_sedang','wc_guru_laki_rusak_berat',
        'wc_guru_laki_rusak_total','jml_wc_guru_laki','wc_guru_perempuan_baik','wc_guru_perempuan_rusak_ringan','wc_guru_perempuan_rusak_sedang',
        'wc_guru_perempuan_rusak_berat','wc_guru_perempuan_rusak_total','jml_wc_guru_perempuan','wc_siswa_laki_baik','wc_siswa_laki_rusak_ringan','wc_siswa_laki_rusak_sedang',
        'wc_siswa_laki_rusak_berat','wc_siswa_laki_rusak_total','jml_wc_siswa_laki','wc_siswa_perempuan_baik','wc_siswa_perempuan_rusak_ringan','wc_siswa_perempuan_rusak_sedang',
        'wc_siswa_perempuan_rusak_berat','wc_siswa_perempuan_rusak_total','jml_wc_siswa_perempuan','created_by','created_at','updated_by','updated_at'];

    public function scopeFilter($query, $request)
    {
        if ($request->has('s')) {
            $query->where(function($query) use ($request) {
                $query->where('dapodik_sekolah_wc.nama_sekolah', 'like', '%'.$request->get('s').'%');
            });
        }
        return $query;
    }

    public function sekolah(): BelongsTo
    {
        return $this->belongsTo('Modules\Dapodik\Models\DapodikSekolahModel', 'npsn','npsn');
    }

    public function user_created(): BelongsTo
    {
        return $this->belongsTo('Modules\Users\Models\UsersModel', 'created_by');
    }

    public function user_updated(): BelongsTo
    {
        return $this->belongsTo('Modules\Users\Models\UsersModel', 'updated_by');
    }

}
