<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ManagerController;

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

Route::get("/", function () {
    return view("welcome");
});

Route::group(["middleware" => ["auth:manager"]], function () {
    Route::get("/manager", [ManagerController::class, "top"])->name(
        "manager.top"
    );
});

Route::get("/manager/register", [
    ManagerController::class,
    "showRegisterForm",
])->name("manager.register.page");
Route::post("/manager/register", [ManagerController::class, "register"])->name(
    "manager.register"
);
Route::get("/manager/login", [ManagerController::class, "showLoginForm"])->name(
    "manager.login.page"
);
Route::post("/manager/login", [ManagerController::class, "login"])->name(
    "manager.login"
);

Route::post(
    "/line/webhook/message",
    "App\Http\Controllers\LineWebhookController@message"
)->name("line.webhook.message");
