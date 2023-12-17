<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\Quizcontroller;
use App\Http\Controllers\ReponseController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return Inertia('Home');
});
Route::get('/questions',[QuestionController::class,'index'])->name('questions');
Route::post('/questions',[QuestionController::class,'store']);
Route::put('/questions',[QuestionController::class,'update']);
Route::delete('/questions/{question}', [QuestionController::class, 'destroy']);
Route::get('/quiz',[Quizcontroller::class,'index']);
Route::put('/Reponses',[ReponseController::class,'update']);
