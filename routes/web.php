<?php

use App\Http\Controllers\SuperAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/super-admin', [SuperAdmin::class, 'index']);
