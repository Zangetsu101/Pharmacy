<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'id'            =>  $this->id,
            'medicine_id'   =>  $this->medicine->id,
            'medicine_name' =>  $this->medicine->name,
            'company_name'  =>  $this->medicine->company->name,
            'date'          =>  $this->date,
            'quantity'      =>  $this->quantity,
            'price'         =>  $this->price
        ];
    }
}
