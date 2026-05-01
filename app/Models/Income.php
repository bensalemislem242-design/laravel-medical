<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $fillable = ['title', 'amount', 'income_date'];

    protected $casts = [
        'income_date' => 'date',
    ];
}
