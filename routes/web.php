<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskController;

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

// Root route - redirects to the login page if not authenticated
Route::get('/', function () {
    return view('welcome');
});

// Authentication routes for user registration, login, and password reset
Auth::routes();

// Home route - displays the dashboard/home page after login
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/', function () {
    return redirect('/login');
});

// Task resource routes - provides all CRUD routes for Task resource
Route::resource('tasks', TaskController::class);

// Route to edit a task's status - displays a form to update task status
Route::get('/tasks/{task}/edit-status', [TaskController::class, 'editStatus'])
    ->name('tasks.editStatus');

    
// Route to update a task's status - processes the form submission
Route::put('/tasks/{task}/update-status', [TaskController::class, 'updateStatus'])
    ->name('tasks.updateStatus');

