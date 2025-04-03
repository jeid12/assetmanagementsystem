<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_tag',
        'category',
        'model',
        'serial_number',
        'brand',
        'specifications',
        'purchase_date',
        'warranty_expiry',
        'current_status',
        'current_school_id',
        'purchase_cost',
        'notes'
    ];

    protected $casts = [
        'specifications' => 'array',
        'purchase_date' => 'date',
        'warranty_expiry' => 'date',
    ];

    // Relationships
    public function school()
    {
        return $this->belongsTo(School::class, 'current_school_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function maintenance()
    {
        return $this->hasMany(Maintenance::class);
    }
}