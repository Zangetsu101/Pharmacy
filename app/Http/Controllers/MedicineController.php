<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Medicine;
use App\Price;
use App\GenericName;
use App\DosageForm;
use App\Http\Resources\MedicineResource;
use App\Http\Resources\DosageFormResource;
use App\Http\Resources\GenericNameResource;

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
        $medicines=Medicine::with(['company','price','dosage_form','generic_name'])->get();
        return MedicineResource::collection($medicines);
    }

    public function sortedIndex()
    {
        $medicines=Medicine::with('company')->orderBy('name','asc')->get();
        return MedicineResource::collection($medicines);
    }
    
    public function generic_names()
    {
        $generic_names=GenericName::orderBy('name','asc')->get();
        return GenericNameResource::collection($generic_names);
    }
    
    public function dosage_forms()
    {
        $dosage_forms=DosageForm::orderBy('name','asc')->get();
        return DosageFormResource::collection($dosage_forms);
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
        if($request->generic_name_id)
            $medicine->generic_name_id=$request->generic_name_id;
        else
        {
            $generic_name=new GenericName;
            $generic_name->name=$request->generic_name;
            $generic_name->save();
            $medicine->generic_name_id=$generic_name->id;
        }
        if($request->dosage_form_id)
            $medicine->dosage_form_id=$request->dosage_form_id;
        else
        {
            $dosage_form=new DosageForm;
            $dosage_form->name=$request->dosage_form;
            $dosage_form->save();
            $medicine->dosage_form_id=$dosage_form->id;
        }
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
        $medicine->dosage_form;
        $medicine->generic_name;
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
        if($request->generic_name_id)
            $medicine->generic_name_id=$request->generic_name_id;
        else
        {
            $generic_name=new GenericName;
            $generic_name->name=$request->generic_name;
            $generic_name->save();
            $medicine->generic_name_id=$generic_name->id;
        }
        if($request->dosage_form_id)
            $medicine->dosage_form_id=$request->dosage_form_id;
        else
        {
            $dosage_form=new DosageForm;
            $dosage_form->name=$request->dosage_form;
            $dosage_form->save();
            $medicine->dosage_form_id=$dosage_form->id;
        }
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
