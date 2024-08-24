<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// routes/api.php

use App\Http\Controllers\UserController;

Route::post('/register', [UserController::class, 'register']);

