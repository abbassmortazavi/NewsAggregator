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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title')->index()->unique()->nullable();
            $table->text('content')->nullable();
            $table->string('type')->index()->nullable();
            $table->text('description')->nullable();
            $table->string('author')->index()->nullable();
            $table->json('source')->nullable();
            $table->string('category')->nullable();
            $table->string('url')->nullable();
            $table->text('url_to_image')->nullable();
            $table->dateTime('published_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
