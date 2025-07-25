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

        Schema::create('learnings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('application_no')->nullable();
            $table->date('application_date')->nullable();
            $table->string('dl_covs')->nullable();
            $table->string('learning_no')->nullable();
            $table->date('learning_created_date')->nullable();
            $table->date('learning_expired_date')->nullable();
            $table->date('appointment_date')->nullable();
            $table->string('rto_office')->nullable();
            $table->string('attendance')->nullable();
            $table->string('result')->nullable();
            $table->string('status')->default('1'); // Assuming you want to track the status of the learning
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('learnings');
    }
};
