<?php

use core\lib\Route;
Route::get('/user/:id', 'user/get');
Route::run();
