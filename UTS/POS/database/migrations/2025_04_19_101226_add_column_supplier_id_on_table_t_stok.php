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
        Schema::table('t_stok', function (Blueprint $table) {
            $table->unsignedBigInteger('supplier_id')->index()->after ('stok_id');
            $table->foreign('supplier_id')->references('supplier_id')->on('m_supplier');
        });
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('t_stok', function (Blueprint $table) {
            $table->column('supplier_id');
        }); 
    }
};
