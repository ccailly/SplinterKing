<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SnapshotRequest extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = 'account_id';
}
