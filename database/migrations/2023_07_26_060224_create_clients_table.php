<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name', 63)->nullable(false);
            $table->string('sex', 15)->nullable(false);
            $table->string('phone', 15)->nullable(false);
            $table->string('address', 127);
        });

        DB::statement('ALTER TABLE `clients` MODIFY `phone` VARCHAR(15) UNIQUE NOT NULL;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
