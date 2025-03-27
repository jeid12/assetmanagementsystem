<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestType extends Model
{
    protected $fillable = ['name', 'slug', 'description'];

public function requests()
{
    return $this->hasMany(SchoolRequest::class);
}
}