<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontEndController;



route::get('/',[FrontEndController::class,'index'])->name('home');
route::get('/scholar-detail',[FrontEndController::class,'scholarview'])->name('scholarList');

