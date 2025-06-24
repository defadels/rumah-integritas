<?php

namespace Modules\Users\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UsersProfileModel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'users_profile';
    protected $primaryKey = 'user_id';
    protected $fillable = [
        'user_id',
        'bio',
        'alamat',
        'keterangan',
        'company_name',
        'website',
        'social_facebook',
        'social_twitter',
        'social_instagram',
        'social_linkedln',
        'social_skype',
        'social_github',
        'created_by',
        'updated_by'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo('Modules\Users\Models\UsersModel', 'user_id');
    }

}
