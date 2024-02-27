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
        Schema::create('pokemon_images', function (Blueprint $table) {
            $table->id();
            $table->string('description')->nullable();
            $table->string('url');
            $table->integer('pokemon_id');

            $table->foreign('pokemon_id')
                ->references('id')
                ->on("pokemon")
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pokemon_images');
    }
};
