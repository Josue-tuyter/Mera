<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/historia', function () {
    return view('historia');
});

Route::get('/metodos', function () {
    return view('metodos');
});
