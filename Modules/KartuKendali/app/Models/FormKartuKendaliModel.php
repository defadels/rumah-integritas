<?php

namespace Modules\KartuKendali\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\KartuKendali\Database\factories\FormKartuKendaliModelFactory;
use App\Models\User;

class FormKartuKendaliModel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'form_kartu_kendali';
    protected $fillable = [
        'kode_sub',
        'sub_kegiatan',
        'sub_bidang',
        'pekerjaan',
        'rekanan',
        'pagu_dana',
        'spk_no',
        'bap_tgl',
        'bap_no',
        'bast_tgl',
        'bast_no',
        'bapem_tgl',
        'bapem_no',
        'spp_no',
        'spp_nilai',
        'sisa_anggaran',
        'keterangan',
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

    protected static function newFactory(): FormKartuKendaliModelFactory
    {
        //return FormKartuKendaliModelFactory::new();
    }
}
