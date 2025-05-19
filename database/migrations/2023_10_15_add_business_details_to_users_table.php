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
        Schema::table('users', function (Blueprint $table) {
            $table->string('business_name')->nullable();
            $table->string('business_type')->nullable();
            $table->string('business_registration_number')->nullable();
            $table->string('business_address')->nullable();
            $table->string('business_registration_document')->nullable();
            $table->string('business_phone')->nullable();
            $table->string('business_email')->nullable();
            $table->string('business_website')->nullable();
            $table->text('business_description')->nullable();
            $table->string('business_logo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'business_name',
                'business_type',
                'business_registration_number',
                'business_address',
                'business_registration_document',
                'business_phone',
                'business_email',
                'business_website',
                'business_description',
                'business_logo',
            ]);
        });
    }
};