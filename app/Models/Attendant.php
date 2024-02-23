<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendant extends Model
{
    use HasFactory;
    protected $fillable = [
     'emp_id',
     'user_id',
     'started_at',
     'ended_at',
     'status'
    ];
}