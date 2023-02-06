<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'mail',
        'password',
        'qr_code',
        'user_id',
        'birthdate',
        'hasKids',
    ];

    public function qr_link()
    {
        if ($this->qr_link) {
            return $this->qr_link;
        } else {
            return "http://chart.googleapis.com/chart?cht=qr&chl=$this->qr_code&choe=UTF-8&chs=400x400&chld=M|2";
        }
    }
}
