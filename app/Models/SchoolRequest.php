<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolRequest extends Model
{
    protected $fillable = ['school_id', 'request_type_id', 'token_id', 'requester_name', 'requester_email', 'details', 'status'];

public function school()
{
    return $this->belongsTo(School::class);
}

public function requestType()
{
    return $this->belongsTo(RequestType::class);
}

public function token()
{
    return $this->belongsTo(RequestToken::class, 'token_id');
}
}