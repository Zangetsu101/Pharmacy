<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    //
    public function medicine()
    {
        return $this->belongsTo('App\Medicine');
    }
}
