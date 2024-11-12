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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id('booking_id');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Foreign keys to bookable items (only one will be used per booking)
            $table->unsignedBigInteger('room_id')->nullable();
            $table->unsignedBigInteger('pool_id')->nullable();
            $table->unsignedBigInteger('activity_id')->nullable();
            $table->unsignedBigInteger('hall_id')->nullable();

            // Define foreign key constraints
            $table->foreign('room_id')->references('room_id')->on('rooms')->onDelete('set null');
            $table->foreign('pool_id')->references('pool_id')->on('pools')->onDelete('set null');
            $table->foreign('activity_id')->references('activity_id')->on('activities')->onDelete('set null');
            $table->foreign('hall_id')->references('hall_id')->on('halls')->onDelete('set null');

            $table->decimal('payment_amount', 10, 2);
            $table->string('payment_method');
            $table->dateTime('check_in')->nullable();
            $table->dateTime('check_out')->nullable();
            $table->string('status')->default('pending');

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
