<?php

use Illuminate\Support\Facades\Route;
use Danshin\Comment\Http\Controllers\FormController;
use Danshin\Comment\Http\Controllers\LogController;

Route::middleware("throttle:30,1")->group( function() {
    Route::post('danshin/comment/log', LogController::class)->name("danshin.comment.log");
    Route::post('danshin/comment/{lang}', FormController::class)->name("danshin.comment");
});
