<?php

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');




use App\Http\Controllers\api\PostController;
use Illuminate\Support\Facades\Route;


Route::apiResource('/posts', PostController::class);
