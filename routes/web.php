<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FilesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UserController;
use App\Models\Files;
use App\Models\Reports;
use App\Models\User;
use App\Repositories\FileRepository;
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
    Route::get('/',[DashboardController::class,'index'])->name('dashboard');

    # rute /dashboard yang tersedia
    Route::group(['prefix' => 'dashboard'],function (){
        Route::get('/',[DashboardController::class,'index'])->name('dashboard');
    });

    # rute /profile yang tersedia
    Route::group(['prefix' => 'profile'],function (){
        Route::get('/',[ProfileController::class,'edit'])->name('profile');
        Route::put('/',[ProfileController::class,'update']);
    });

    # rute /report yang tersedia
    Route::get('/report/incoming',[ReportsController::class,'incoming'])
    ->name('report.incoming');
    Route::get('/report/sent',[ReportsController::class,'sent'])
    ->name('report.sent');
    Route::post('/report/{report}/add-file',[ReportsController::class,'addfile'])
    ->name('report.add-file');

    Route::resource('report',ReportsController::class)->names('report');

    # rute /file yang tersedia
    Route::get('/file/{file}/download',function(Files $file){
        return response()->download(storage_path('app/'.$file->file_path));
    })->name('file.download');
    Route::post('/file/{file}/edit',function(Files $file){
        $report = $file->report;
        $repo = new FileRepository();
        $repo->acceptFile($file);
        return response()->json(["url"=>route('report.show',['report'=>$report->slug])],201);
    })->name('file.edit');

    Route::get('/file/{file}/reset',function(Files $file){
        $repo = new FileRepository();
        $repo->resetAcceptFile($file);
        return redirect()->back();
    })->name('file.reset');

    Route::resource('file',FilesController::class)->names([
    'show' => 'file.show',
    'update' => 'file.update',
    'store' => 'file.store'
    ]);

    Route::get('/user/{user}/resource',function(User $user){
        $user->loadMissing('roles:id');
        return response()->json($user);
    });
    Route::put('/user/{user}/roles',function(User $user){
        $user->roles()->sync(request()->input('roles'));
        return response()->json($user->loadMissing('roles:id'));
    });
    Route::resource('user',UserController::class)->names([
    'index' => 'user.index',
    'show' => 'user.show',
    'update' => 'user.update',
    'store' => 'user.store'
    ]);

    Route::get('/logout',function(){
        auth()->logout();
        return redirect(route('login'));
    })->name('logout');
});
