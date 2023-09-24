<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportsController;
use Illuminate\Support\Facades\Route;

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


# user belum login hanya dapat akses rute ini
Route::group(['middleware'=>'guest'], function (){
    Route::group(['prefix' => 'register'], function () {
        Route::get('/', [AuthController::class, 'register'])->name('register');
        Route::post('/', [AuthController::class, 'store']);
    });

    Route::group(['prefix' => 'login'], function () {
        Route::get('/', [AuthController::class, 'index'])->name('login');
        Route::post('/', [AuthController::class, 'login']);
    });
});

# user telah login hanya dapat akses rute ini
Route::group(['middleware'=>'auth'], function (){
    Route::get('/', function () {
        return view('welcome');
    });

    # rute /dashboard yang tersedia
    Route::group(['prefix' => 'dashboard'],function (){
        Route::get('/',[DashboardController::class,'index'])->name('dashboard');
    });

    # rute /report yang tersedia
    Route::resource('report',ReportsController::class)->names([
    'index' => 'report.index',
    'create' => 'report.create',
    'store' => 'report.store',
    ]);

    # rute /file yang tersedia
    Route::resource('file',ReportsController::class)->names([
    'show' => 'file.show',
    'update' => 'file.update',
    'store' => 'file.store'
    ]);

    Route::get('/logout',function(){
        auth()->logout();
        return redirect(route('login'));
    })->name('logout');
});
