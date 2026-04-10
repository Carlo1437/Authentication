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
        Schema::create('vehicle_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->text('email_address');
            $table->bigInteger('phone_number');
            $table->text('address');
            $table->string('vehicle_type');
            $table->string('plate_number');
            $table->date('registration_date');
            $table->string('engine_number');
            $table->string('chassis_number');
            $table->string('document');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_registrations');
    }
};
