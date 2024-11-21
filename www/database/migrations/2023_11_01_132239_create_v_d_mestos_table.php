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
        Schema::create('v_d_mestos', function (Blueprint $table) {
            $table->id();
            $table->integer('ID_VD')->nullable(false);
            $table->string('NAME',20)->nullable(false);
            $table->smallInteger('N_JUR')->nullable(false);
            $table->dateTime('DT_HRAN')->nullable(false);
            $table->smallInteger('ID_HRAN')->nullable(false);
            $table->dateTime('DT_KVIT')->nullable(false);
            $table->string('N_KVIT',20)->nullable(false);
            $table->binary('F_KVIT')->nullable(false);
            $table->smallInteger('MESTO_HRAN')->nullable(false);
            $table->text('ADRES_HRAN');
            $table->string('FIO_SDAL',200)->nullable(false);
            $table->string('DOL_SDAL',200)->nullable(false);
            $table->string('FIO_PRIN',200)->nullable(false);
            $table->string('DOL_PRIN',200)->nullable(false);
            $table->string('SHKAF',10)->nullable(false);
            $table->string('POLKA',10)->nullable(false);
            $table->dateTime('DT_REG')->nullable(true);
            $table->dateTime('DT_IZM')->nullable(true);
            $table->smallInteger('SHPOLZ')->nullable(true);
            $table->smallInteger('SHPOLZ1')->nullable(true);
            $table->smallInteger('IBD_ARX')->nullable(true);
            $table->text('DOP_INFO')->nullable(true);


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('v_d_mestos');
    }
};
