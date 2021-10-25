<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $table = 'companies';

    protected $fillable = [
        'fcmToken',
        'device',
        'ip',
        'refresh_token',
        'last_active',
    ];
}
