<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('uploaded_files', function (Blueprint $table) {

            $table->id(); // Уникальный идентификатор файла
            $table->timestamps(); // Дата создания и обновления записи
    
            $table->string('filename')->nullable(); // Имя файла
            $table->string('original_filename'); // Оригинальное имя файла
            $table->string('extension'); // Расширение файла
            $table->string('mime_type'); // MIME-тип файла
            $table->string('size'); // Размер файла
    
            $table->string('file_path'); // Путь к файлу в базе данных
            $table->string('thumb_100x100_path')->nullable(); // Путь к оптимизированному файлу в базе данных
    
            $table->boolean('is_image')->default(false); // Флаг, указывающий, является ли файл изображением
        
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uploaded_files');
    }
};
