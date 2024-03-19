<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\signUpController;
use App\Http\Controllers\studentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ConditionController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\ReservationController;

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

Route::post("/login", [LoginController::class, "login"]);
Route::post("/signup", [signUpController::class, "signup"]);
Route::get("/checkUser", [LoginController::class, "checkLogin"]);
Route::post("/logout", [LoginController::class, "logout"]);

Route::post("/submit-equipment", [EquipmentController::class, 'submitEquipment'])->name('submitEquipment');
Route::post("/update-equipment", [EquipmentController::class, 'updateEquipment']);
Route::post("/return-missing-equipment", [EquipmentController::class, "returnMissingEquipment"]);
Route::get("/get-equipments", [EquipmentController::class, "getEquipments"]);
Route::get("/get-max-stock", [EquipmentController::class, "getMaxStock"]);
Route::get("/get-all-equipment-status", [EquipmentController::class, "getAllEquipmentStatus"]);
Route::get("/get-equipment-name-and-image", [EquipmentController::class, "getEquipmentNameAndImage"]);
Route::post("/add-and-dispose-equipment-stock", [EquipmentController::class, "AddandDisposeEquipmentStock"]);
Route::post("/get-equipment", [EquipmentController::class, "getEquipment"]);
Route::post("/delete-equipment", [EquipmentController::class, "deleteEquipment"]);
Route::post('/submit-equipment-order', [EquipmentController::class, 'submitEquipmentOrder']);
Route::get("/get-equipment-condition", [EquipmentController::class, "getEquipmentCondition"]);



Route::post("/submit-category", [CategoryController::class, 'submitCategory'])->name('submitCategory');
Route::get("/get-categories", [CategoryController::class, 'getCategories']);


Route::get("/get-conditions", [ConditionController::class, 'getConditions']);

Route::get("/get-reservations", [ReservationController::class, "getReservations"]);
Route::post("/submit-reservation", [ReservationController::class, 'submitReservation'])->name('submitReservation');
Route::post("/delete-reservation", [ReservationController::class, "deleteReservation"]);
Route::get("/get-reservation-orders", [ReservationController::class, "getReservationOrder"]);
Route::post("/approve-reservation", [ReservationController::class, "approveReservation"]);
Route::post("/reject-reservation", [ReservationController::class, "rejectReservation"]);
Route::post("/return-reservation", [ReservationController::class, "returnReservation"]);
Route::get("/get-status-table", [ReservationController::class, "getStatusTable"]);

//kababaan amin
Route::get('/{vue?}', function(){
    return view('app');
})->where('vue', '[\/\w\.-]*');
