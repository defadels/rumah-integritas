<?php

namespace Modules\Users\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UsersModel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'users';
    protected $hidden = ['password'];
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active',
        'last_login_at',
        'last_login_ip',
        'created_by',
        'updated_by'
    ];

    public function scopeFilter($query, $request)
    {
        if ($request->has('s')) {
            $query->where(function($query) use ($request) {
                $query->where('users.name', 'like', '%'.$request->get('s').'%')
                    ->OrWhere('users.email', 'like', '%'.$request->get('s').'%')
                    ->OrWhere('users.phone', 'like', '%'.$request->get('s').'%');
            });
        }
        if ($request->has('aktif')) {
            $query->where('users.is_active', '=', $request->get('aktif'));
        }
        return $query;
    }

}
