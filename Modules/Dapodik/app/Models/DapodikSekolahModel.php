<?php

namespace Modules\Dapodik\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DapodikSekolahModel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'dapodik_sekolah';
    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = ['id','nama_sekolah','npsn','status','bentuk','alamat','kecamatan','kabupaten','kecamatan_id','kabupaten_id','kode_reg','provinsi_id','created_by','created_at','updated_by','updated_at'];

    public function scopeFilter($query, $request)
    {
        if ($request->has('s')) {
            $query->where(function($query) use ($request) {
                $query->where('dapodik_sekolah.nama_sekolah', 'like', '%'.$request->get('s').'%')
                    ->OrWhere('dapodik_sekolah.npsn', 'like', '%'.$request->get('s').'%');
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


}
