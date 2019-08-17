<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    //
    public function company()
    {
        return $this->belongsTo('App\Company');
    }

    public function prices()
    {
        return $this->hasMany('App\Price');
    }

    public function price()
    {
        return $this->hasMany('App\Price')->whereNull('till');
    }
}
