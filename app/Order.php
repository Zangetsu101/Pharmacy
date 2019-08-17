<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    public function medicine()
    {
        return $this->belongsTo('App\Medicine');
    }
}
