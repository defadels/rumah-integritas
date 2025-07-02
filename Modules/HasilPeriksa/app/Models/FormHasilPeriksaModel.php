<?php

namespace Modules\HasilPeriksa\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\HasilPeriksa\Database\factories\FormHasilPeriksaModelFactory;
use App\Models\User;

class FormHasilPeriksaModel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'form_hasil_periksa';
    protected $fillable = [
        'name',
        'file_attach',
        'users_receiver',
        'users_id',
        'parent_id',
        'is_reply',
        'reply_level',
        'reply_message',
        'status_approval',
        'approved_by',
        'approved_at',
        'approval_notes',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    // Relationships
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'users_receiver');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    // Reply system relationships
    public function parent()
    {
        return $this->belongsTo(FormHasilPeriksaModel::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(FormHasilPeriksaModel::class, 'parent_id')->orderBy('created_at', 'asc');
    }

    public function allReplies()
    {
        return $this->hasMany(FormHasilPeriksaModel::class, 'parent_id')->with('replies')->orderBy('created_at', 'asc');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status_approval', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status_approval', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status_approval', 'rejected');
    }

    public function scopeMainDocuments($query)
    {
        return $query->where('is_reply', false)->whereNull('parent_id');
    }

    public function scopeReplies($query)
    {
        return $query->where('is_reply', true)->whereNotNull('parent_id');
    }

    protected static function newFactory(): FormHasilPeriksaModelFactory
    {
        //return FormHasilPeriksaModelFactory::new();
    }
}
