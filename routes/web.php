<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Login;
use App\Livewire\ProductPage;
use App\Livewire\Users;
use App\Livewire\Dashboard;
use App\Livewire\Productmagement;
use App\Livewire\Categories;
use App\Livewire\Purchases;
use App\Livewire\Receive;
use App\Livewire\AuditTrails;

use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkflowController;
Route::get('/getuser', [UserController::class, 'getall'])->name('getalluser');

Route::get('/getworkflowdetail', [WorkflowController::class, 'getworkflowdetail'])->name('getworkflowdetail');   
Route::get('/startflow', [WorkflowController::class, 'startflow'])->name('startflow');  
Route::get('/processflow', [WorkflowController::class, 'processflow'])->name('processflow'); 

Route::get('/dashboard', Dashboard::class)->name('dashboard')->middleware('check.session');
Route::get('/store', ProductPage::class)->name('store');
Route::get('/', Login::class)->name('login');
Route::get('/managementuser', Users::class)->name('managementuser')->middleware('check.session');
Route::get('/receiveproduct', Receive::class)->name('receiveproduct')->middleware('check.session');
Route::get('/productmanagement', Productmagement::class)->name('productmanagement')->middleware('check.session');
Route::get('/categorymanagement', Categories::class)->name('categorymanagement')->middleware('check.session');
Route::get('/purchases', Purchases::class)->name('purchases')->middleware('check.session');
Route::get('/auditrails', AuditTrails::class)->name('auditrails')->middleware('check.session');

// Route::get('/register', Register::class)->name('register');

