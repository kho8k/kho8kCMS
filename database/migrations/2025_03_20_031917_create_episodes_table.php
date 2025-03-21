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
        Schema::create('episodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_id')->constrained('movies')->cascadeOnDelete();
            $table->string('server');
            $table->string('name');
            $table->string('slug');
            $table->string('type');
            $table->string('link')->nullable();
            $table->boolean('has_report')->default(false);
            $table->string('report_message', 512)->nullable();
            $table->timestamps();
            $table->index(['movie_id', 'slug'], 'episodes_movie_id_slug_index');
            $table->index('movie_id', 'episodes_movie_id_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('episodes');
    }
};
