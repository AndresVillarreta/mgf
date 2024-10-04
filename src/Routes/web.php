<?php


Route::get('/', 'index');
Route::get('/login', 'login');
Route::get('*', '404');
Route::post('/', 'index');