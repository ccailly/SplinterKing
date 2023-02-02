<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'mail',
        'password',
        'qr_code',
        'user_id',
        'birthdate',
        'hasKids',
    ];

    public $timestamps = false; 
}
