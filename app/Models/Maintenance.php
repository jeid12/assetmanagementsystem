<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'school_id',
        'reported_date',
        'reported_by',
        'issue_description',
        'priority',
        'status',
        'technician_id',
        'start_date',
        'completion_date',
        'resolution_details',
        'parts_replaced',
        'cost',
        'downtime_days'
    ];

    protected $casts = [
        'reported_date' => 'datetime',
        'start_date' => 'datetime',
        'completion_date' => 'datetime',
        'cost' => 'decimal:2',
    ];

    // Relationships
    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }
}