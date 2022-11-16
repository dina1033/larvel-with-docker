<?php

use App\Http\Controllers\api\TransectionController;
use App\Http\Controllers\api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => 'api.key'],function (){
    Route::get('all-users',[UserController::class,'getUsers']);
    Route::post('add-user',[UserController::class,'addUsers']);
    Route::post('add-transection',[TransectionController::class,'addTransections']);
});
