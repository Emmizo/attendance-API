<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
   protected $fillable = [
    'id',
    'f_name',
    'l_name',
    'email',
    'user_id',
    'employee_identifier',
    'phone_number',
    'is_active'
];
}