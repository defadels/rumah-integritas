<?php

namespace Modules\Dapodik\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DapodikSekolahLabModel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'dapodik_sekolah_lab';
    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = ['id','nama_sekolah','npsn','lab_komputer_baik','lab_komputer_rusak_ringan','lab_komputer_rusak_sedang','lab_komputer_rusak_berat',
        'lab_komputer_rusak_total','jml_lab_komputer','lab_bahasa_baik','lab_bahasa_rusak_ringan','lab_bahasa_rusak_sedang',
        'lab_bahasa_baik','lab_bahasa_rusak_ringan','lab_bahasa_rusak_sedang','lab_bahasa_rusak_berat','lab_bahasa_rusak_total',
        'jml_lab_bahasa','lab_ipa_baik','lab_ipa_rusak_ringan','lab_ipa_rusak_sedang','lab_ipa_rusak_berat','lab_ipa_rusak_total','jml_lab_ipa',
        'lab_fisika_baik','lab_fisika_rusak_ringan','lab_fisika_rusak_sedang','lab_fisika_rusak_berat','lab_fisika_rusak_total','jml_lab_fisika',
        'lab_biologi_baik','lab_biologi_ringan','lab_biologi_rusak_sedang','lab_biologi_rusak_berat','lab_biologi_rusak_total','jml_lab_biologi',
        'created_by','created_at','updated_by','updated_at'];

    public function scopeFilter($query, $request)
    {
        if ($request->has('s')) {
            $query->where(function($query) use ($request) {
                $query->where('dapodik_sekolah_lab.nama_sekolah', 'like', '%'.$request->get('s').'%');
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
