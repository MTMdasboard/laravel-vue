<?php
use App\Http\Controllers\DonateController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;



Route::get("/news", [NewsController::class, "index"])->name("news");

Route::get("/news/create", [NewsController::class, "create"])->name("news.create");

Route::patch("/news", [NewsController::class, "store"])->name("news.store");

Route::get("/news/{news}", [NewsController::class, "show"])->name("news.show");

Route::get("/news/{news}/edit", [NewsController::class, "edit"])->name("news.edit");

Route::patch("/news/{news}", [NewsController::class, "update"])->name("news.update");

Route::delete("/news/{news}", [NewsController::class, "delete"])->name("news.delete");

Route::get("/news/{news}/like", [NewsController::class, "like"])->name("news.like");

Route::post('/news/{news}/comments', [CommentController::class, 'store'])->name('comments.store');

// Route::resource('/posts/{post}/comments', CommentController::class)->only(['index', 'show']);

// Route::get("/likes", [DonateController::class,"index"])->name("donates");