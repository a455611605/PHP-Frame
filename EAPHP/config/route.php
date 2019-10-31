<?php

use core\lib\Route;
Route::get('/', 'user/test');
Route::get('/user/:username', 'user/get');
