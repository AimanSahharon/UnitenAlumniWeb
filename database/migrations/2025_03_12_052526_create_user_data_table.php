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
            $table->foreignID("ic");
            $table->string("full_name");
            $table->string("studentID");
            $table->integer("year_of_graduation");
            $table->string("email_address");
            $table->integer("mobile_number");
            $table->string("permanent_address");
            $table->string("college");
            $table->string("education_level");
            $table->string("name_of_programme");
            $table->string("current_employment_status");
            $table->string("employment_level");
            $table->string("employment_sector");
            $table->string("occupational_field");
            $table->string("range_of_salary");
            $table->string("position");
            $table->string("name_of_organisation");
            $table->string("location_of_workplace");




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
