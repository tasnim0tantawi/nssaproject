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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            //title
            $table->string('title');
            // user_id
            $table->foreignId('owner_id')
                ->constrained('users')
                ->onDelete('cascade');
            //description
            $table->text('description');
            // level of difficulty
            $table->enum('experience', ['easy', 'medium', 'hard']);
            // scope of the project
            $table->text('scope');
            // objectives
            $table->text('objectives');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
