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
        Schema::create('asigna', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_producto');
            $table->bigInteger('id_venta');
            $table->integer('cantidad');
            $table->integer('total_por_producto');
            $table->foreign('id_producto')->references('id')->on('producto');
            $table->foreign('id_venta')->references('id')->on('venta');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asigna');
    }
};
