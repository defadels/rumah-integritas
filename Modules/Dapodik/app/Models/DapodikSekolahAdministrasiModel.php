<?php

namespace Modules\Dapodik\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DapodikSekolahAdministrasiModel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'dapodik_sekolah_administrasi';
    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = ['id','nama_sekolah','npsn','bentuk_pendidikan','status_sekolah','alamat','kelurahan','kecamatan','kabupaten','provinsi','kelurahan_id','kecamatan_id','kabupaten_id','provinsi_id',
        'kodepos','lintang','bujur','no_telp','npwp','nama_kepsek','nip_kepsek','no_hp_kepsek','email_kepsek','status_kepsek',
        'periode_data','tmt_akreditasi','akreditasi','nama_operator','email_operator','no_hp_operator','sinkron_terakhir','bendahara_bos',
        'created_by','created_at','updated_by','updated_at'];

    public function scopeFilter($query, $request)
    {
        if ($request->has('s')) {
            $query->where(function($query) use ($request) {
                $query->where('dapodik_sekolah_administrasi.nama_sekolah', 'like', '%'.$request->get('s').'%');
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

    protected function casts(): array
    {
        return [
            'tmt_akreditasi' => 'date',
            'sinkron_terakhir' => 'datetime',
        ];
    }


}
