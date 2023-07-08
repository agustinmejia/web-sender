<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\ServersController;
use App\Http\Controllers\SenderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('login', function () {
    return redirect('admin/login');
})->name('login');

Route::get('/', function () {
    return redirect('admin');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
    Route::get('/', function(){
        return redirect('admin/profile');
    })->name('voyager.dashboard');

    // Server
    Route::get('servers/{server}/test', [ServersController::class, 'test'])->name('servers.test');

    // Sender
    Route::get('sender', [SenderController::class, 'index'])->name('sender.index');
    Route::post('sender/send', [SenderController::class, 'send'])->name('sender.send');
});

// Clear cache
Route::get('/admin/clear-cache', function() {
    Artisan::call('optimize:clear');
    return redirect('/admin/profile')->with(['message' => 'Cache eliminada.', 'alert-type' => 'success']);
})->name('clear.cache');
