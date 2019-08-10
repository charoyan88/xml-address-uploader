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

Route::prefix('v1')->group(function () {
    Route::prefix('upload')->group(function () {
            Route::post('xml', 'UploadController@uploadXml');
    });
    Route::prefix('find')->group(function () {
        Route::get('', 'AddressController@findAddress');
        Route::get('adressess', 'AddressController@findAddressesGroups');
    });
});
