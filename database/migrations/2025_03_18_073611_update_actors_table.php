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
        Schema::table('actors', function (Blueprint $table) {
            $table->renameColumn('actorName', 'name');
            $table->renameColumn('staticURL', 'slug');
            $table->string('name_md5')->unique();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->string('bio')->nullable();
            $table->string('thumb_url', 2048)->nullable();
            $table->string('seo_title')->nullable();
            $table->string('seo_des')->nullable();
            $table->string('seo_key')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('actors', function (Blueprint $table) {
            //
        });
    }
};
