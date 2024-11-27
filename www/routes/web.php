<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\HostController;
use \App\Http\Controllers\IndexController;
use \App\Http\Controllers\MakeDhcpConfigController;

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

Route::get('/', IndexController::class)->name('index');

Route::resource('host', HostController::class);

Route::get('dhcp/make/config', MakeDhcpConfigController::class)->name('make.config');
