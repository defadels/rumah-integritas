<?php

namespace Modules\Dapodik\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DapodikSekolahLainModel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'dapodik_sekolah_lain';
    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = ['id','nama_sekolah','npsn','meja_siswa','kursi_siswa','papan_tulis','komputer',
        'guru','tendik','profile', 'created_by','created_at','updated_by','updated_at'];

    public function scopeFilter($query, $request)
    {
        if ($request->has('s')) {
            $query->where(function($query) use ($request) {
                $query->where('dapodik_sekolah_lain.nama_sekolah', 'like', '%'.$request->get('s').'%');
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
