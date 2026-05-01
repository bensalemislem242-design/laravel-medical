<?php
// database/migrations/xxxx_xx_xx_create_prescriptions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->string('medication');
            $table->string('dosage');
            $table->text('instructions')->nullable();
            $table->text('content')->nullable();  // AJOUTER CE CHAMP
            $table->string('file')->nullable();
            $table->timestamp('prescribed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('prescriptions');
    }
};