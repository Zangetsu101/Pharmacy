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

    public function dosage_form()
    {
        return $this->belongsTo('App\DosageForm','dosage_form_id');
    }

    public function generic_name()
    {
        return $this->belongsTo('App\GenericName','generic_name_id');
    }
}
