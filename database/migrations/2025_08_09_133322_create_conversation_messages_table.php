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
        Schema::create('conversation_messages', function (Blueprint $table) {
            $table->id();
            $table->morphs('conversation'); // conversation_type, conversation_id
            $table->foreignId('sender_id')->constrained('clients')->onDelete('cascade');
            $table->enum('type', ['text', 'photo', 'video', 'file', 'system'])->default('text');
            $table->text('content');
            $table->string('media_path')->nullable();
            $table->boolean('is_read')->default(false);
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(['sender_id']);
            $table->index(['is_read']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversation_messages');
    }
};
