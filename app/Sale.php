<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    //
    public function medicine()
    {
        return $this->belongsTo('App\Medicine');
    }
}
