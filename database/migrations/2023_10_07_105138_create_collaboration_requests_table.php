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
        Schema::create('collaboration_requests', function (Blueprint $table) {
            $table->id();
            // user_id 
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // project_id 
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            // status 
            $table->enum(
                'status',
                [
                    'pending',
                    'accepted',
                    'rejected'
                ]
            
            )->default('pending');
            $table->unique(['user_id', 'project_id']);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collaboration_requests');
    }
};
