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
    Schema::table('appointments', function (Blueprint $table) {
        $table->dropForeign(['hospital_id']); // مهم
        $table->dropColumn('hospital_id');
    });

    Schema::table('appointments', function (Blueprint $table) {
        $table->unsignedBigInteger('hospital_id')->nullable();
    });
}

public function down()
{
    Schema::table('appointments', function (Blueprint $table) {
        $table->dropColumn('hospital_id');
    });

    Schema::table('appointments', function (Blueprint $table) {
        $table->unsignedBigInteger('hospital_id')->nullable(false);
    });
}
};
