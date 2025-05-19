<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Boarding Houses
        Schema::create('boarding_houses', function (Blueprint $table) {
            $table->id();
            $table->string('nearby_school')->nullable();
            $table->integer('max_students')->nullable();
            $table->integer('current_students')->nullable();
            $table->enum('gender_policy', ['male', 'female', 'mixed'])->default('mixed');
            $table->boolean('shared_rooms')->default(false);
            $table->integer('room_capacity')->nullable();
            $table->text('rules')->nullable();
            $table->timestamps();
        });

        // Hotels
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->integer('star_rating')->nullable();
            $table->boolean('has_restaurant')->default(false);
            $table->boolean('has_conference_room')->default(false);
            $table->timestamps();
        });

        // Lodges
        Schema::create('lodges', function (Blueprint $table) {
            $table->id();
            $table->boolean('has_meeting_hall')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lodges');
        Schema::dropIfExists('hotels');
        Schema::dropIfExists('boarding_houses');
    }
};