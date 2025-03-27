<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $fillable = [
        'name', 'province', 'district', 'sector', 
        'phone', 'email', 'leaderName'
    ];
    public function requests()
{
    return $this->hasMany(SchoolRequest::class);
}
}