<?php
use App\Http\Controllers\DonateController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\Posts\CommentController;
use Illuminate\Support\Facades\Route;



Route::get("/News", [NewsController::class, "index"])->name("news");

Route::get("/News/Create", [NewsController::class, "create"])->name("news.create");

Route::post("/News", [NewsController::class, "store"])->name("news.store");

Route::get("/News/{news}", [NewsController::class, "show"])->name("news.show");

Route::get("/News/{news}/edit", [NewsController::class, "edit"])->name("news.edit");

Route::put("/News/{news}", [NewsController::class, "update"])->name("news.update");

Route::delete("/News/{news}", [NewsController::class, "delete"])->name("news.delete");

Route::get("/News/{news}/like", [NewsController::class, "like"])->name("news.like");

// Route::resource('/posts/{post}/comments', CommentController::class)->only(['index', 'show']);

// Route::get("/likes", [DonateController::class,"index"])->name("donates");