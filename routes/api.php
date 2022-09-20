<?php

use App\Domain\Product\Controllers\ProductGetController;
use Illuminate\Http\JsonResponse;
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

Route::get('/test', fn(Request $request): JsonResponse => response()->json(['message' => 'Hello World']));

Route::get('/products', ProductGetController::class);


