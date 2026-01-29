<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    //
    protected $fillable = ['table_id', 'rating', 'content'];

    public function table()
    {
        return $this->belongsTo(Table::class);
    }
}
