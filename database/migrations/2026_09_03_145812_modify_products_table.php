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
        Schema::table('products', function (Blueprint $table) {
            // Modificar columnas existentes sin borrar datos
        $table->string('descripcion', 500)->nullable()->change();
        $table->integer('stock')->default(0)->change();
        $table->double('precio_compra')->default(0)->change();
        $table->double('precio_venta')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('descripcion', 500)->nullable(false)->change();
            $table->integer('stock')->default(null)->change();
            $table->double('precio_compra')->default(null)->change();
            $table->double('precio_venta')->default(null)->change();
        });
    }
};
