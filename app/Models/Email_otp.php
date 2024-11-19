<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email_otp extends Model
{
    use HasFactory;
    protected $fillable = [
        'EmailOTP',
        'email',
    ];
}
