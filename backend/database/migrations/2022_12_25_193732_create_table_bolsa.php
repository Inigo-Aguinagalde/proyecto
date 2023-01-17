<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
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
        Schema::create('bolsa', function (Blueprint $table) {
            $table->uuid('id');
            $table->timestamp('fecha');
            $table->float('variacion');
            $table->float('Euros');
            $table->foreignUuid('compañia_id');
        });

        Schema::table('bolsa', function (Blueprint $table) {
            $table->foreign('compañia_id')
                ->references('id')
                ->on('compañias')
                ->onDelete('cascade');
        });

        Artisan::command('db:seed --class=BolsaSeeder');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_bolsa');
    }
};
