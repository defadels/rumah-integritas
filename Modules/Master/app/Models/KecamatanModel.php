<?php

namespace Modules\Master\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KecamatanModel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'kecamatan';

    public function scopeFilter($query, $request)
    {
        if ($request->has('s')) {
            $query->where(function($query) use ($request) {
                $query->where('kecamatan.nama_kecamatan', 'like', '%'.$request->get('s').'%');
            });
        }
        return $query;
    }

}
