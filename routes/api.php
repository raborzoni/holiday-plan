<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\HolidayPlanController;

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

Route::group(['middleware' => ['cors', 'json.response']], function () {

    // public routes
    Route::post('/login', [ApiAuthController::class, 'login']);
    Route::post('/register', [ApiAuthController::class, 'register']);

});

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [ApiAuthController::class, 'logout']);

    Route::get('/holidays', [HolidayPlanController::class, 'index']);
    Route::post('/holidays', [HolidayPlanController::class, 'store']);
    Route::get('/holidays/{id}', [HolidayPlanController::class, 'show']);
    Route::put('/holidays/{id}', [HolidayPlanController::class, 'update']);
    Route::delete('/holidays/{id}', [HolidayPlanController::class, 'destroy']);
    Route::get('/holidays/{id}/pdf', [HolidayPlanController::class, 'generatePDF']);
});