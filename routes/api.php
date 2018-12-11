<?php


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

// All methods work with code name, which send to view

// Get Route
Route::get('/route', 'Api\RouteController@route');

// Get Full
Route::get('/full-route', 'Api\FullRouteController@route');

// Reset game
Route::get('/reset', 'Api\ResetController@reset');

// Get Point by point number
Route::get('/route/point/{number}', 'Api\PointController@point');

// Get all points
Route::get('/points', 'Api\PointController@points');

// Get current point
Route::get('/point/current', 'Api\PointController@currentPoint');


// Get hint by point number and hint number
Route::get('/point/{point}/hint/{hint}', 'Api\HintController@hint');

// Get answer true or false by point number
Route::get('/point/{point}/answer', 'Api\AnswerController@checkAnswer');


/*
 * Check code paid
 */

Route::get('check_success', 'Api\PaymentController@checkSuccess');