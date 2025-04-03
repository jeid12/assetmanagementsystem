<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'report_month',
        'submission_date',
        'submitted_by',
        'total_devices',
        'devices_in_use',
        'devices_in_storage',
        'devices_in_maintenance',
        'usage_hours',
        'issues_reported',
        'educational_impact',
        'challenges_faced',
        'needs_additional_devices',
        'verification_status',
        'verified_by',
        'verification_notes'
    ];

    protected $casts = [
        'submission_date' => 'datetime',
        'needs_additional_devices' => 'boolean',
    ];

    // Relationships
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function submitter()
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}