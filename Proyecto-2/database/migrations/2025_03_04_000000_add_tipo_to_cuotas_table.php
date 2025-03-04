<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('cuotas', function (Blueprint $table) {
            $table->enum('tipo', ['mensual', 'ordinaria', 'extraordinaria', 'otra'])
                  ->nullable()
                  ->after('empleado_id');
        });
    }

    public function down()
    {
        Schema::table('cuotas', function (Blueprint $table) {
            $table->dropColumn('tipo');
        });
    }
};