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

        Route::group(['prefix' => 'task'], function () {
            Route::get('list', 'TaskController@index');
            Route::post('create', 'TaskController@store');
            Route::get('detail/{id}', 'TaskController@show');
            Route::put('update/{id}', 'TaskController@update');
            Route::delete('delete/{id}', 'TaskController@destroy');
        });

        Route::group(['prefix' => 'feedback'], function () {
            Route::get('list', 'FeedbackController@index');
            Route::post('create', 'FeedbackController@store');
            Route::get('detail/{id}', 'FeedbackController@show');
            Route::put('update/{id}', 'FeedbackController@update');
            Route::delete('delete/{id}', 'FeedbackController@destroy');
        });

        Route::group(['prefix' => 'room'], function () {
            Route::get('list', 'RoomController@index');
            Route::post('create', 'RoomController@store');
            Route::get('detail/{id}', 'RoomController@show');
            Route::put('update/{id}', 'RoomController@update');
            Route::delete('delete/{id}', 'RoomController@destroy');
        });

        Route::group(['prefix' => 'position'], function () {
            Route::get('list', 'PositionController@index');
            // Route::post('create', 'PositionController@store');
            // Route::get('detail/{id}', 'PositionController@show');
            // Route::put('update/{id}', 'PositionController@update');
            // Route::delete('delete/{id}', 'PositionController@destroy');
        });

        Route::group(['prefix' => 'contract'], function () {
            Route::get('list', 'ContractController@index');
            // Route::post('create', 'ContractController@store');
            // Route::get('detail/{id}', 'ContractController@show');
            // Route::put('update/{id}', 'ContractController@update');
            // Route::delete('delete/{id}', 'ContractController@destroy');
        });
    });
});

