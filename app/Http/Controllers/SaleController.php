<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sale;
use App\Http\Resources\SaleResource;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $sales=Sale::with('medicine.company')->get();
        return SaleResource::collection($sales);
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
        $sale=new Sale;
        $sale->date=$request->date;
        $sale->medicine_id=$request->medicine_id;
        $sale->quantity=$request->quantity;
        $sale->price=$request->price;
        if($sale->save())
            return new SaleResource($sale);
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
        $sale=Sale::find($id);
        $sale->medicine->company;
        return new SaleResource($sale);
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
        $sale=Sale::find($id);
        $sale->date=$request->date;
        $sale->medicine_id=$request->medicine_id;
        $sale->quantity=$request->quantity;
        $sale->price=$request->price;
        if($sale->save())
            return new SaleResource($sale);
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
        $sale=Sale::find($id);
        if($sale->delete())
            return new SaleResource($sale);
    }
}
