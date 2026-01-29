<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $fillable = ['name', 'status', 'qr_code_url'];

    protected $casts = [
        'status' => 'string',
    ];
}
