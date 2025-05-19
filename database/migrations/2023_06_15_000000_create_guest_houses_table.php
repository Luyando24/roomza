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
        Schema::create('guest_houses', function (Blueprint $table) {
            $table->id();
            $table->boolean('has_conference_room')->default(false);
            $table->boolean('has_restaurant')->default(false);
            $table->boolean('has_bar')->default(false);
            $table->boolean('has_swimming_pool')->default(false);
            $table->boolean('has_wifi')->default(false);
            $table->boolean('has_tv')->default(false);
            $table->boolean('has_parking')->default(false);
            $table->boolean('has_security')->default(false);
            $table->time('check_in_time')->nullable();
            $table->time('check_out_time')->nullable();
            $table->text('rules')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guest_houses');
    }
};