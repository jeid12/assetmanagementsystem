<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestToken extends Model
{
    protected $fillable = ['token', 'school_id', 'request_type_id', 'email', 'expires_at', 'is_used'];

public function school()
{
    return $this->belongsTo(School::class);
}

public function requestType()
{
    return $this->belongsTo(RequestType::class);
}
}