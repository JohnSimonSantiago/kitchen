<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\signUpController;
use App\Http\Controllers\studentController;
use App\Http\Controllers\EquipmentController;

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

// Route::get('/', function () {
//     return view('app');
// });

Route::post("/submit-student", [studentController::class, 'createStudent'])->name("createStudent");
Route::get("/get-students", [studentController::class, "getStudents"]);
Route::post("/get-student", [studentController::class, "getStudent"]);
Route::post("/update-student", [studentController::class, "updateStudent"]);
Route::post("/delete-student", [studentController::class, "deleteStudent"]);
Route::post("/login", [LoginController::class, "login"]);
Route::post("/signup", [signUpController::class, "signup"]);
Route::get("/checkUser", [LoginController::class, "checkLogin"]);
Route::post("/logout", [LoginController::class, "logout"]);

Route::post('/submit-equipment', [EquipmentController::class, 'submitEquipment'])->name('submitEquipment');
Route::post('/update-equipment', [EquipmentController::class, 'submitEquipment'])->name('updateEquipment');
Route::get("/get-equipment", [EquipmentController::class, "getEquipment"]);
Route::post("/delete-equipment", [EquipmentController::class, "deleteEquipment"]);

//kababaan amin
Route::get('/{vue?}', function(){
    return view('app');
})->where('vue', '[\/\w\.-]*');
