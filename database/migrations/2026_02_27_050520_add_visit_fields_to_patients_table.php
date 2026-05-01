<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->date('last_visit')->nullable();
            $table->date('next_appointment')->nullable();
        });
    }

    public function down()
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn('last_visit');
            $table->dropColumn('next_appointment');
        });
    }
};
