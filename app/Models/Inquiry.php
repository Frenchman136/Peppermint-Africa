<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'organisation',
        'service',
        'message',
        'notes',
        'status',
        'ip_address',
    ];
}
