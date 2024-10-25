<?php

use App\Http\Controllers\ShortTimeDataController;
use App\Http\Controllers\UserAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('register',[UserAuthController::class,'register']);
Route::post('login',[UserAuthController::class,'login']);
Route::get('logged',[UserAuthController::class,'checkLogin'])->middleware('auth:sanctum');;
Route::post('logout',[UserAuthController::class,'logout'])
  ->middleware('auth:sanctum');


  Route::post('weatherdata/short/store',[ShortTimeDataController::class,'store'])
  ->middleware('auth:sanctum');
  