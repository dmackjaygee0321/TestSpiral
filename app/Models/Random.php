<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Random extends Model
{
   protected $fillable = [
    'id','values','flag'
    ];
    
    public function breakdowns()
    {
        return $this->hasMany('App\Models\Breakdown','random_id');
    }
}
