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
        Schema::create('projects_tags', function (Blueprint $table) {
            $table->id();
            //project_id
            $table->foreignId('project_id')
                ->constrained()
                ->onDelete('cascade');
            //tag_id
            $table->foreignId('tag_id')
                ->constrained()
                ->onDelete('cascade');
            $table->unique(['project_id', 'tag_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects_tags');
    }
};
