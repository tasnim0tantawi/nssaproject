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
        Schema::create('projects_users', function (Blueprint $table) {
            $table->id();
            // user_id 
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');
            // project_id
            $table->foreignId('project_id')
                ->constrained()
                ->onDelete('cascade');
            // role
            $table->enum(
                'role',
                [
                    'admin',
                    'creator',
                    'contributor'
                ]
            
            )->default('contributor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects_users');
    }
};
