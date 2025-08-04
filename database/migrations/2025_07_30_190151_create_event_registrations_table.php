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
        Schema::create('event_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->string('email');
            $table->json('responses'); // Store dynamic form responses
            $table->timestamp('registered_at');
            $table->boolean('confirmation_sent')->default(false);
            $table->boolean('reminder_sent')->default(false);
            $table->timestamps();
            
            $table->unique(['event_id', 'email']); // Prevent duplicate registrations
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_registrations');
    }
};
