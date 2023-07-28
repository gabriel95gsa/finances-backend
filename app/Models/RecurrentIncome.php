<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecurrentIncome extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'default_value', 'status'];
}
