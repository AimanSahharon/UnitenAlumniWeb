<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function() {
    return view('home');
});

Route::get('/profile', function() {
    return view('profile');
});

Route::get('/mycard', function() {
    return view('mycard');
});

Route::get('/benefits', function() {
    return view('benefits');
});

Route::get('/alumnihub', function() {
    return view('alumnihub');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
