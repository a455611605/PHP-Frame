<?php

use core\lib\Route;
Route::get('/', 'user/ds');
Route::post('/user', 'user/get');
Route::get('/user', 'user/get1');

Route::run();
