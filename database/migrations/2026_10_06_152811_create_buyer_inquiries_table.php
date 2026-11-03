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
        Schema::create('buyer_inquiries', function (Blueprint $table) {

            $table->id();

            // buyer_id
            $table->foreignId('buyer_id')
                ->constrained('users')
                ->onDelete('cascade');


            // Property ID
            $table->unsignedBigInteger('property_id');

            // Property kis table se hai
            $table->string('property_source')->nullable();

            // Buyer message
            $table->text('message');

            // Inquiry status
            $table->string('status')->default('pending');
            $table->string('reply')->default('pending');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buyer_inquiries');
    }
};
