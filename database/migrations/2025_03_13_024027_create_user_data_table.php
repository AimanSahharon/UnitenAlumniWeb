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
        Schema::create('user_data', function (Blueprint $table) {
            $table->id();
            $table->string('ic_passport')->unique();
            $table->string('full_name')->nullable();
            $table->string('student_id')->nullable();
            $table->integer('year_of_graduation')->nullable();
            $table->string('email_address')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('permanent_address')->nullable();
            $table->string('college')->nullable();
            $table->string('education_level')->nullable();
            $table->string('name_of_programme')->nullable();
            $table->string('current_employment_status')->nullable();
            $table->string('employment_level')->nullable();
            $table->string('employment_sector')->nullable();
            $table->string('occupational_field')->nullable();
            $table->string('range_of_salary')->nullable();
            $table->string('position_designation')->nullable();
            $table->string('name_of_organisation')->nullable();
            $table->string('location_of_workplace')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_data');
    }
};
