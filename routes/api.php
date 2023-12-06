<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CvController;
use App\Http\Controllers\OfferController;


Route::Post('register',[UserController::class,'register']);
Route::Post('login',[UserController::class,'login']);
Route::post('addCv', [CvController::class, 'addCv'])->middleware('auth:api');
Route::get('cv/{id}/pdf', [CvController::class, 'generateCvPdf'])->middleware('auth:api');
Route::post('addoffer', [OfferController::class, 'addoffer'])->middleware('auth:api');
Route::post('deleteoffer', [OfferController::class, 'deleteoffer'])->middleware('auth:api');
Route::post('editoffer', [OfferController::class, 'editoffer'])->middleware('auth:api');

Route::get('/email/verification/{token}', [UserController::class, 'verifyEmail'])->name('email.verification');

