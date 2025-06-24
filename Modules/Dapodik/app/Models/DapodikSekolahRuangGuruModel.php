<?php

namespace Modules\Dapodik\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DapodikSekolahRuangGuruModel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'dapodik_sekolah_ruang_guru';
    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = ['id','nama_sekolah','npsn','ruang_kepsek_baik','ruang_kepsek_rusak_ringan','ruang_kepsek_rusak_sedang','ruang_kepsek_rusak_berat',
        'ruang_kepsek_rusak_total','jml_ruang_kepsek','ruang_guru_baik','ruang_guru_rusak_ringan','ruang_guru_rusak_sedang',
        'ruang_guru_rusak_berat','ruang_guru_rusak_total','jml_ruang_guru','ruang_tu_baik','ruang_tu_rusak_ringan','ruang_tu_rusak_sedang',
        'ruang_tu_rusak_berat','ruang_tu_rusak_total','jml_ruang_tu','created_by','created_at','updated_by','updated_at'];

    public function scopeFilter($query, $request)
    {
        if ($request->has('s')) {
            $query->where(function($query) use ($request) {
                $query->where('dapodik_sekolah_ruang_guru.nama_sekolah', 'like', '%'.$request->get('s').'%');
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
