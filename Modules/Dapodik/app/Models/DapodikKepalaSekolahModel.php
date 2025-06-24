<?php

namespace Modules\Dapodik\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DapodikKepalaSekolahModel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'dapodik_kepala_sekolah';
    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = ['id','nama_lengkap','jk','nik','nuptk','nip','no_sk','tmt_kepala','no_hp','email','status_kepsek',
        'nama_sekolah','npsn','kecamatan','kabupaten','kecamatan_id','kabupaten_id','provinsi_id','created_by','created_at','updated_by','updated_at'];

    public function scopeFilter($query, $request)
    {
        if ($request->has('s')) {
            $query->where(function($query) use ($request) {
                $query->where('dapodik_kepala_sekolah.nama_lengkap', 'like', '%'.$request->get('s').'%');
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
            'tmt_kepala' => 'date',
        ];
    }


}
