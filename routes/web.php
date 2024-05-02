<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuperAdmin;
use App\Http\Controllers\SuperAdminSetting;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/super-admin', [SuperAdmin::class, 'index']);
Route::get('/login', [AuthController::class,'login']);
Route::post('/login-user', [AuthController::class,'loginUser'])->name('login-user');
Route::get('/super-admin/add-user', [SuperAdminSetting::class,'superAdminAddUser']);
Route::get('/super-admin/view-user', [SuperAdmin::class,'superAdminShowUsers']);
Route::post('/super-admin/register-user', [SuperAdminSetting::class,'registerUser'])->name('register-user');
