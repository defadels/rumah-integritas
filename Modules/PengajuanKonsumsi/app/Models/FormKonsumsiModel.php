<?php

namespace Modules\PengajuanKonsumsi\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\PengajuanKonsumsi\Database\factories\FormKonsumsiModelFactory;
use App\Models\User;

class FormKonsumsiModel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'form_konsumsi';
    protected $fillable = [
        'name',
        'email',
        'judul_rapat',
        'waktu',
        'jml_konsumsi',
        'setuju',
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

    protected static function newFactory(): FormKonsumsiModelFactory
    {
        //return FormKonsumsiModelFactory::new();
    }
}
