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
        Schema::create('clientcar', function (Blueprint $table) {
            $table->bigInteger('id_client')->unsigned();
            $table->bigInteger('id_car')->unsigned();

            $table->foreign('id_client')->references('id')->on('clients');
            $table->foreign('id_car')->references('id')->on('cars');

            $table->primary(['id_client', 'id_car']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientcar');
    }
};
