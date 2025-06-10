<?php

use App\Http\Controllers\NoteappController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::controller(ProfileController::class)->middleware('auth:sanctum')->group(function(){
Route::post("store","store");
Route::post("alldata","alldata");
Route::post("show/{id}","show");
});

Route::controller(UserController::class)->group(function(){
Route::post("register","register");
Route::post("login","login");
Route::post("verifyCode","verifyCode");
Route::post("resendVerificationCode","resendVerificationCode");
Route::post("logout","logout")->middleware('auth:sanctum');
});




Route::post("getdatauser",[UserController::class,"getdatauser"]);
Route::post("user/{id}",[UserController::class,"show"]);


Route::post("addNote",[NoteappController::class,"addNote"]);
Route::post("veiwNote",[NoteappController::class,"veiwNote"]);
Route::post("updateNote",[NoteappController::class,"updateNote"]);
Route::post("deleteNote",[NoteappController::class,"deleteNote"]);
