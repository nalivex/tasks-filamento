<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $dates = [
        'date_limit'
      ];

    protected $guarded = ['id'];

    public $timestamps = false;
}
