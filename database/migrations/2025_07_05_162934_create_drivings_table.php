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
        Schema::create('drivings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('application_no')->nullable();
            $table->date('application_date')->nullable();
            $table->string('dl_number')->nullable();
            $table->string('dl_covs')->nullable();
            $table->string('nt_validity')->nullable();
            $table->string('tr_validity')->nullable();
            $table->date('license_approved_date')->nullable();
            $table->date('appointment_date')->nullable();
            $table->string('rto_office')->nullable();
            $table->string('attendance')->nullable();
            $table->string('result')->nullable();
            $table->string('status')->default('1'); // Assuming you want to track the status of the driving
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivings');
    }
};
