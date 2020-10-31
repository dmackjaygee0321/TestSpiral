<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class Breakdown extends Model
{

   protected $fillable = [
    'values','random_id'
    ];

    public function random()
    {
        return $this->belongsTo('App\Models\Random');
    }

}
