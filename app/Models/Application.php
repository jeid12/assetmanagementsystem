<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'application_date',
        'required_device_type',
        'quantity_requested',
        'purpose',
        'urgency_level',
        'status',
        'approval_date',
        'approved_by',
        'notes',
        'application_letter_pdf',
        'application_letter_filename',
        'application_letter_size',
        'application_letter_hash'
    ];

    protected $casts = [
        'application_date' => 'datetime',
        'approval_date' => 'datetime',
    ];

    // Relationships
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function devices()
    {
        return $this->hasMany(Device::class);
    }
}