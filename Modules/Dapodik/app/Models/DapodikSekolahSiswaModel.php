<?php

namespace Modules\Dapodik\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DapodikSekolahSiswaModel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'dapodik_sekolah_siswa';
    protected $dates = ['created_at', 'updated_at'];

    protected $fillable = ['id','nama_sekolah','npsn','peserta_didik_baru','peserta_didik_lulus','peserta_didik_putus','peserta_didik_mengulang',
        'tka_l','tka_p','tkb_l','tkb_p','t1_l','t1_p','t2_l','t2_p','t3_l','t3_p','t4_l','t4_p','t5_l',	't5_p',	't6_l','t6_p','t7_l',
        't7_p','t8_l','t8_p','t9_l','t9_p','t10_l','t10_p','t11_l','t11_p','t12_l','t12_p','t13_l','t13_p','pkt_a_l','pkt_a_p','pkt_b_l',
        'pkt_b_p','pkt_c_l','pkt_c_p','pd_l','pd_p','pd_total','u0_l','u0_p','u1_l','u1_p','u2_l','u2_p','u3_l','u3_p','u4_l','u4_p',
        'u5_l','u5_p','u6_l','u6_p','u7_l','u7_p','u8_l','u8_p','u9_l','u9_p','u10_l','u10_p','u11_l','u11_p','u12_l','u12_p','u13_l',
        'u13_p','u14_l','u14_p','u15_l','u15_p','u16_l','u16_p','u17_l','u17_p','u18_l','u18_p','u19_l','u19_p','u20_l','u20_p',
        'u21_l','u21_p','l_islam','p_islam','l_kristen','p_kristen','l_katholik','p_katholik','l_hindu','p_hindu','l_budha',
        'p_budha','l_konghucu','p_konghucu','l_kepercayaan','p_kepercayaan','l_agama_lain','p_agama_lain','l_lulus','p_lulus','l_mutasi',
        'p_mutasi','l_dikeluarkan','p_dikeluarkan','l_mundur','p_mundur','l_putus','p_putus','l_wafat','p_wafat','l_hilang',
        'p_hilang','l_lainnya','p_lainnya','created_by','created_at','updated_by','updated_at'];

    public function scopeFilter($query, $request)
    {
        if ($request->has('s')) {
            $query->where(function($query) use ($request) {
                $query->where('dapodik_sekolah_siswa.nama_sekolah', 'like', '%'.$request->get('s').'%');
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
