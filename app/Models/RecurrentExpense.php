<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecurrentExpense extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'default_value', 'limit_value', 'due_day', 'status'];
}
