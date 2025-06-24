<?php

namespace Modules\Dapodik\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DapodikSiswaModel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'dapodik_siswa';
    //protected $dates = ['tgl_lahir','created_at', 'updated_at'];
    protected $fillable = ['id','nisn','nik','nama_lengkap','tmp_lahir','tgl_lahir','nama_ibu','jk','tingkat','alamat','npsn','kelurahan_id','kecamatan_id','kabupaten_id','provinsi_id','created_by','created_at','updated_by','updated_at'];

    public function scopeFilter($query, $request)
    {
        if ($request->has('s')) {
            $query->where(function($query) use ($request) {
                $query->where('dapodik_siswa.nama_lengkap', 'like', '%'.$request->get('s').'%')
                    ->OrWhere('dapodik_siswa.nisn', 'like', '%'.$request->get('s').'%')
                    ->OrWhere('dapodik_siswa.nik', 'like', '%'.$request->get('s').'%');
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
            'tgl_lahir' => 'date',
        ];
    }


}
