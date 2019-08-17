<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Medicine;
use App\Price;
use App\Http\Resources\MedicineResource;

class MedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $medicines=Medicine::with(['company','price'])->get();
        return MedicineResource::collection($medicines);
    }

    public function sortedIndex()
    {
        $medicines=Medicine::with('company')->orderBy('name','asc')->get();
        return MedicineResource::collection($medicines);
    }
    
    public function generic_names()
    {
        $generic_names=Medicine::select('generic_name')->distinct()->get();
        return $generic_names;
    }
    
    public function dosage_forms()
    {
        $dosage_forms=Medicine::select('dosage_form')->distinct()->get();
        return $dosage_forms;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $medicine=new Medicine;
        $medicine->name=$request->name;
        $medicine->company_id=$request->company_id;
        $medicine->generic_name=$request->generic_name;
        $medicine->dosage_form=$request->dosage_form;
        if($medicine->save())
        {
            $price=new Price;
            $price->medicine_id=$medicine->id;
            $price->from=now()->toDateTimeString('Y-m-d');
            $price->till=null;
            $price->wholesale_price=$request->wholesale_price;
            $price->retail_price=$request->retail_price;
            $price->save();
            return new MedicineResource($medicine);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $medicine=Medicine::find($id);
        $medicine->company;
        $medicine->price;
        return new MedicineResource($medicine);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $medicine=Medicine::find($id);
        $medicine->name=$request->name;
        $medicine->company_id=$request->company_id;
        $medicine->generic_name=$request->generic_name;
        $medicine->dosage_form=$request->dosage_form;
        if($medicine->save())
        {
            $price=Price::where('medicine_id',$id)->whereNull('till')->first();
            if($price->wholesale_price!=$request->wholesale_price||$price->retail_price!=$request->retail_price)
            {
                $price->till=now()->toDateTimeString('Y-m-d');
                $price->save();

                $price=new Price;
                $price->medicine_id=$medicine->id;
                $price->from=now()->toDateTimeString('Y-m-d');
                $price->till=null;
                $price->wholesale_price=$request->wholesale_price;
                $price->retail_price=$request->retail_price;
                $price->save();
            }
            return new MedicineResource($medicine);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $medicine=Medicine::find($id);
        if($medicine->delete())
            return new MedicineResource($medicine);
    }
}
