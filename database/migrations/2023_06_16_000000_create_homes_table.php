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
        Schema::create('homes', function (Blueprint $table) {
            $table->id();
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->decimal('square_meters', 10, 2)->nullable();
            $table->integer('year_built')->nullable();
            $table->boolean('has_garage')->default(false);
            $table->integer('garage_capacity')->nullable();
            $table->boolean('has_garden')->default(false);
            $table->decimal('garden_size', 10, 2)->nullable();
            $table->boolean('has_swimming_pool')->default(false);
            $table->string('property_type')->nullable(); // detached, semi-detached, townhouse, etc.
            $table->string('construction_materials')->nullable();
            $table->string('roof_type')->nullable();
            $table->boolean('is_new_construction')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homes');
    }
};