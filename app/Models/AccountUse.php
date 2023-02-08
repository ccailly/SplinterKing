<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountUse extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'account_id',
        'user_id',
        'reward',
        'used_at',
    ];
}
