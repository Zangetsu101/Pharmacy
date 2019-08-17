<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $orders=Order::with('medicine.company')->get();
        return OrderResource::collection($orders);
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
        $order=new Order;
        $order->date=$request->date;
        $order->medicine_id=$request->medicine_id;
        $order->quantity=$request->quantity;
        $order->price=$request->price;
        if($order->save())
            return new OrderResource($order);
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
        $order=Order::find($id);
        $order->medicine->company;
        return new OrderResource($order);
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
        $order=Order::find($id);
        $order->date=$request->date;
        $order->medicine_id=$request->medicine_id;
        $order->quantity=$request->quantity;
        $order->price=$request->price;
        if($order->save())
            return new OrderResource($order);
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
        $order=Order::find($id);
        if($order->delete())
            return new OrderResource($order);
    }
}
