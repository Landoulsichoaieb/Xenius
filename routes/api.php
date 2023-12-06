<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CvController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ApplyController;


Route::Post('register',[UserController::class,'register']);
Route::Post('login',[UserController::class,'login']);
Route::post('addCv', [CvController::class, 'addCv'])->middleware('auth:api');
Route::get('cv/{id}/pdf', [CvController::class, 'generateCvPdf'])->middleware('auth:api');
Route::get('cvuser/{id}/pdf', [CvController::class, 'genCvPdfByIdUser'])->middleware('auth:api');
Route::post('addoffer', [OfferController::class, 'addoffer'])->middleware('auth:api');
Route::post('deleteoffer', [OfferController::class, 'deleteoffer'])->middleware('auth:api');
Route::post('editoffer', [OfferController::class, 'editoffer'])->middleware('auth:api');
Route::post('apply', [ApplyController::class, 'apply'])->middleware('auth:api');
Route::get('fetchallapplies', [ApplyController::class, 'fetchallapplies'])->middleware('auth:api');
Route::get('fetchuserapplies', [ApplyController::class, 'fetchuserapplies'])->middleware('auth:api');

Route::get('/email/verification/{token}', [UserController::class, 'verifyEmail'])->name('email.verification');

