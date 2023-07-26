<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('brand', 31)->nullable(false);
            $table->string('model', 31)->nullable(false);
            $table->string('color', 31)->nullable(false);
            $table->string('number', 15)->nullable(false);
            $table->boolean('is_parked', 15)->nullable(false);
            $table->dateTime('parked_at');
        });

        DB::statement('ALTER TABLE `cars` MODIFY `number` VARCHAR(31) UNIQUE NOT NULL;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
