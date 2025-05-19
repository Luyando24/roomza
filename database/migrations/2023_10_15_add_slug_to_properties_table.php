<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\Property;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add slug column if it doesn't exist
        if (!Schema::hasColumn('properties', 'slug')) {
            Schema::table('properties', function (Blueprint $table) {
                $table->string('slug')->nullable()->after('title');
            });
            
            // Generate slugs for existing properties
            $properties = Property::all();
            foreach ($properties as $property) {
                $property->slug = Str::slug($property->title);
                $property->save();
            }
            
            // Make slug unique and required
            Schema::table('properties', function (Blueprint $table) {
                $table->string('slug')->unique()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('properties', 'slug')) {
            Schema::table('properties', function (Blueprint $table) {
                $table->dropColumn('slug');
            });
        }
    }
};