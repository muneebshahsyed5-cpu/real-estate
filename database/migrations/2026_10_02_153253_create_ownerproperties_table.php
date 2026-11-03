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
        Schema::create('ownerproperties', function (Blueprint $table) {
             $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            // Property Information
            $table->string('title');
            $table->text('description')->nullable();

            // Type: House, Apartment, Plot, Shop etc.
            $table->string('property_type');

            // Purpose: Sale / Rent
            $table->string('purpose');

            // Price
            $table->decimal('price', 15, 2);

            // Area
            $table->decimal('area', 10, 2);
            $table->string('area_unit');

            // Property Details
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->integer('kitchens')->nullable();

            // Location
            $table->string('location');
            $table->string('city');
            $table->string('address')->nullable();

            // Status
            $table->string('status')->default('pending');

            // Featured Property
            $table->boolean('featured')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ownerproperties');
    }
};
