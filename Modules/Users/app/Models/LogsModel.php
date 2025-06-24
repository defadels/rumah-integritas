<?php

namespace Modules\Users\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogsModel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'logs';
    protected $dates = ['created_at', 'updated_at'];
    protected $primaryKey = 'id';
    protected $fillable = [ 'id', 'env','uid', 'ip_address','message','level','context','extra', 'created_at','updated_at'];

    public function scopeFilter($query, $request)
    {
        if ($request->has('s')) {
            $query->where(function($query) use ($request) {
                $query->where('message', 'like', '%'.$request->get('s').'%');
            });
        }
        return $query;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo('Modules\Users\Models\UsersModel', 'uid');
    }

}
