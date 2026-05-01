<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('specialties', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        // تعديل جدول doctors لإضافة specialty_id
        Schema::table('doctors', function (Blueprint $table) {
            $table->foreignId('specialty_id')->nullable()->constrained('specialties')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropForeign(['specialty_id']);
            $table->dropColumn('specialty_id');
        });

        Schema::dropIfExists('specialties');
    }
};
