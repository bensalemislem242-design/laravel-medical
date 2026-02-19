<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up(): void
{Schema::create('appointments', function (Blueprint $table) {
    $table->id();
    $table->string('motivation');
    $table->date('date');
    $table->time('start_time');
    $table->time('end_time');
    $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');
    $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
    $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
    $table->timestamps();
});

}



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
};
