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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id')->nullable()->constrained()->onDelete('set null');
            $table->string('email')->unique()->nullable();
            $table->string('telegram_nickname')->unique()->nullable();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->float('rating')->default(0);
            $table->integer('dispute_count')->default(0);
            $table->boolean('is_verified')->default(false);
            $table->foreignId('referrer_id')->nullable()->constrained('clients')->onDelete('set null');
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
