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

// Route::apiResources([
//     'item' => 'API\ItemController'
// ]);

Route::get('items-created', 'API\ItemController@index');
Route::post('save-item', 'API\ItemController@store');
Route::put('update-item/{id}', 'API\ItemController@update');
Route::delete('delete-item/{id}', 'API\ItemController@destroy');
