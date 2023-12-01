<?php
use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;



Route::get("/files", [FileController::class, "index"])->name("files");

Route::get("/files/create", [FileController::class, "create"])->name("files.create");

Route::patch("/files", [FileController::class, "store"])->name("files.store");

Route::patch("/files/multiple", [FileController::class, "multiple"])->name("files.multiple");

Route::get("/files/{fileId}", [FileController::class, "edit"])->name("files.edit");

Route::patch("/files/{fileId}", [FileController::class, "update"])->name("files.update");

Route::delete("/files/{fileId}", [FileController::class, "destroy"])->name("files.delete");

Route::get("/files/download/{fileId}", [FileController::class, "download"])->name("files.download");