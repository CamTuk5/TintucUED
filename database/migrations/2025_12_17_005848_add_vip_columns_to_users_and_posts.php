<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
    Schema::table('users', function (Blueprint $table) {
        $table->boolean('is_vip')->default(false);
        $table->dateTime('vip_expires_at')->nullable(); 
    });

    Schema::table('posts', function (Blueprint $table) {
        $table->boolean('is_premium')->default(false);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users_and_posts', function (Blueprint $table) {
            //
        });
    }
};
