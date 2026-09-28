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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
    
            // Standard VARCHAR columns
            $table->string('title');
            $table->string('slug')->unique(); // Adds a unique constraint
            
            // TEXT column for longer content
            $table->text('content'); 
            
            // Optional/Nullable integer column
            $table->integer('views')->default(0); 
            $table->boolean('is_published')->default(false);
            
            // Foreign key column pointing to another table
            $table->foreignId('user_id')->constrained("users")->onDelete('cascade');
            
            // Automatically adds nullable 'created_at' and 'updated_at' columns
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
