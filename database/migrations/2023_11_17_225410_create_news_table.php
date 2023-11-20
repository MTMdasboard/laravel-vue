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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('user_id')->nullable();

            $table->string('title');
            $table->text('content')->nullable();

            $table->timestamp('published_at')->nullable();

            $table->mediumText('base64image')->nullable();

            $table->integer('views')->default(0);
            $table->integer('likes')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
