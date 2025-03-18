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
        Schema::table('catalogs', function (Blueprint $table) {
            $table->renameColumn('catalogName', 'name');
            $table->renameColumn('staticURL','slug');
            $table->integer('paginate')->default(20);
            $table->string('value')->nullable();
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
        Schema::table('catalogs', function (Blueprint $table) {
            //
        });
    }
};
