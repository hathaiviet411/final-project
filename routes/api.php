<?php
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

Route::group(['namespace' => 'App\Http\Controllers\Api'], function () {
    Route::post('auth/login', 'AuthController@login');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::group(['prefix' => 'auth'], function () {
            Route::post('refresh', 'AuthController@refresh');
            Route::get('user', 'AuthController@user');
            Route::post('logout', 'AuthController@logout');
        });

        Route::group(['prefix' => 'department'], function () {
            Route::get('list', 'DepartmentController@index');
            Route::post('create', 'DepartmentController@store');
            Route::get('detail/{id}', 'DepartmentController@show');
            Route::put('update/{id}', 'DepartmentController@update');
            Route::delete('delete/{id}', 'DepartmentController@destroy');
        });
    });
});

