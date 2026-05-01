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
    Schema::table('notifications', function (Blueprint $table) {
        $table->unsignedBigInteger('appointment_id')->nullable()->after('id');

        $table->foreign('appointment_id')
              ->references('id')
              ->on('appointments')
              ->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('notifications', function (Blueprint $table) {
        $table->dropForeign(['appointment_id']);
        $table->dropColumn('appointment_id');
    });
}

};
