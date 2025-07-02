<?php

namespace Modules\BarangPakaiHabis\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\BarangPakaiHabis\Database\factories\FormBarangPakaiHabisModelFactory;
use App\Models\User;

class FormBarangPakaiHabisModel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'form_barang_pakai_habis';
    protected $fillable = [
        'namakegiatan',
        'email',
        'penanggungjawab',
        'tanggalpelaksanaan',
        'waktupelaksanaan',
        'lokasikegiatan',
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

    protected static function newFactory(): FormBarangPakaiHabisModelFactory
    {
        //return FormBarangPakaiHabisModelFactory::new();
    }
}
