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
    public function up()
{
   Schema::create('appointments', function (Blueprint $table) {
    $table->id();
    $table->string('motivation');
    $table->date('date');
    $table->time('start_time');
    $table->time('end_time');
    
    // هذا العمود الجديد
    $table->unsignedBigInteger('doctor_id');
    
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
