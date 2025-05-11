<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('admin.index');
});


Route::get('/products', function () {
    return view('admin.products.index');
});
