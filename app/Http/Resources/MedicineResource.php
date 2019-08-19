<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PriceResource;

class MedicineResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                =>  $this->id,
            'name'              =>  $this->name,
            'generic_name_id'   =>  $this->generic_name->id,
            'generic_name'      =>  $this->generic_name->name,
            'dosage_form_id'    =>  $this->dosage_form->id,
            'dosage_form'       =>  $this->dosage_form->name,
            'company_id'        =>  $this->company->id,
            'company_name'      =>  $this->company->name,
            'wholesale_price'   =>  $this->price->first()->wholesale_price,
            'retail_price'      =>  $this->price->first()->retail_price
        ];
    }
}
