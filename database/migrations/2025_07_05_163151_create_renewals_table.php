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
        Schema::create('renewals', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('application_no')->nullable();
            $table->date('application_date')->nullable();
            $table->string('dl_number')->nullable();
            $table->string('dl_covs')->nullable();
            $table->string('nt_validity')->nullable();
            $table->string('tr_validity')->nullable();
            $table->string('learning_no')->nullable();
            $table->date('license_approval_date')->nullable();
            $table->string('rto_office')->nullable();
            $table->string('result')->nullable();
            $table->string('status')->default('1'); // Assuming you want to track the status of the renewal
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('renewals');
    }
};
