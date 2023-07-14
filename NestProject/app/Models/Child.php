<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    use HasFactory;
    protected $table = 'childs';
    protected $fillable = ['first_name', 'middle_name', 'last_name', 'age','address','city','state','zip_code','country'];
}
