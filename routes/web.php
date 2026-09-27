<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// API Đăng nhập (localhost:8000/api/)
Route::post('/', [AuthController::class, 'login']);

// Các API yêu cầu xác thực bằng Token Middleware
Route::middleware('auth:api')->group(function () {
    
    // API Kiểm tra token hợp lệ
    Route::get('/auth', [AuthController::class, 'auth']);
    
    // API Hello World (Yêu cầu xác thực)
    Route::get('/hello-world', [AuthController::class, 'helloWorld']);
    
});