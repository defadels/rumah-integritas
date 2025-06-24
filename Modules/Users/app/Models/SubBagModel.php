<?php

namespace Modules\Users\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubBagModel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'sub_bag';
    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = ['id','name','created_by','created_at','updated_by','updated_at'];


}
