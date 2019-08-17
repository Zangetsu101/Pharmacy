<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('companies','CompanyController');

Route::apiResource('medicines','MedicineController');

Route::get('/generic_names','MedicineController@generic_names');

Route::get('/dosage_forms','MedicineController@dosage_forms');

Route::apiResource('sales','SaleController');

Route::apiResource('orders','OrderController');

Route::get('/medicines_sorted','MedicineController@sortedIndex');