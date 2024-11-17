<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service',
        'body_request',
        'http_status',
        'body_response',
        'ip_address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
