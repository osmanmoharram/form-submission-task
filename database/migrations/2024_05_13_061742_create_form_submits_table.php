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
        Schema::create('form_submits', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('dob');
            $table->enum('gender', ['male', 'female']);
            $table->string('nationality');
            $table->text('cv');
            $table->string('hr_coordinator_status')->nullable();
            $table->string('hr_manager_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_submits');
    }
};
