<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('type'); // boarding_house, hotel, lodge, etc.
            $table->string('location');
            $table->string('nearest_shopping_mall')->nullable();
            $table->string('nearest_market')->nullable();
            $table->string('nearest_hospital')->nullable();
            $table->string('water_source')->nullable();
            $table->foreignId('area_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('province_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('city_id')->nullable()->constrained()->onDelete('set null');
            $table->string('city_name')->nullable();
            $table->string('province_name')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->string('cover_image')->nullable();
            $table->json('detail_images')->nullable();
            $table->json('amenities')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->string('propertyable_type')->nullable();
            $table->unsignedBigInteger('propertyable_id')->nullable();
            $table->index(['propertyable_type', 'propertyable_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};