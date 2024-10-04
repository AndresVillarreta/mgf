<?php


Route::get('/', 'index');
Route::get('/login', 'login');
Route::get('*', 'index');
Route::post('/', 'index');