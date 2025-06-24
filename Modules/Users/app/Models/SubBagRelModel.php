<?php

namespace Modules\Users\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubBagRelModel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'sub_bag_rel';
    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = ['form_konsumsi_id','sub_bag_id','created_by','created_at','updated_by','updated_at'];


}
