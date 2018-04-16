<?php

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix('auth')->group(function($router) {
    $router->post('login', 'AuthController@login');
    $router->post('logout', 'AuthController@logout');
});
Route::middleware('refresh.token')->group(function($router) {
    $router->get('profile','UserController@profile');
});
