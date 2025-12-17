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
    Schema::create('posts', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete(); 
        $table->foreignId('category_id')->constrained();
        
        // Nội dung chính
        $table->string('title');
        $table->string('slug')->unique();
        $table->longText('content');     
        $table->string('thumbnail')->nullable();
        $table->string('status')->default('draft')->index();
        $table->unsignedBigInteger('views')->default(0);
        $table->float('heat_score')->default(0)->index();      
        $table->timestamp('published_at')->nullable();
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
