<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $fillable = [
        'name', 'province', 'district', 'sector', 
        'phone', 'email', 'leaderName','school-code'
    ];
    public function requests()
{
    return $this->hasMany(SchoolRequest::class);
}
}