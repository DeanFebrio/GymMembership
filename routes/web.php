<?php

use App\Http\Controllers\MembershipController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});