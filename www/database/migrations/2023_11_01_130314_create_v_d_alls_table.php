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
        Schema::create('v_d_alls', function (Blueprint $table) {
            $table->id();
            $table->integer('ID_VD')->nullable(false);
            $table->integer('KATEG_VD')->nullable(false);
            $table->integer('VID_VD')->nullable(false);
            $table->string('NAME',200)->nullable(false);
            $table->integer('KOL')->nullable(true);
            $table->string('VES',14)->nullable(true);
            $table->string('VES_ED',3)->nullable(true);
            $table->string('INV_PACK',200)->nullable(false);
            $table->text('OPISANIE')->nullable(true);
            $table->string('OPASEN',10)->nullable(true);
            $table->binary('F_EXP')->nullable(true);
            $table->integer('N_KVIT')->nullable(true);
            $table->binary('F_KVIT')->nullable(true);
            $table->string('MARKA',200)->nullable(true);
            $table->string('SERIJ',5)->nullable(true);
            $table->string('NOMER',20)->nullable(true);
            $table->string('KALIBR',20)->nullable(true);
            $table->smallInteger('GOD')->nullable(true);
            $table->smallInteger('TYPTS')->nullable(true);
            $table->string('MARKATS',20)->nullable(true);
            $table->string('MODELTS',40)->nullable(true);
            $table->string('VIN',20)->nullable(true);
            $table->string('GOSNOMER',15)->nullable(true);
            $table->smallInteger('COLOR')->nullable(true);
            $table->string('VALUTA',80)->nullable(true);
            $table->integer('NOMINAL')->nullable(true);
            $table->integer('STATUS')->nullable(true);
            $table->integer('CEN')->nullable(true);
            $table->dateTime('DT_REG')->nullable(true);
            $table->dateTime('DT_IZM')->nullable(true);
            $table->smallInteger('SHPOLZ')->nullable(true);
            $table->smallInteger('SHPOLZ1')->nullable(true);
            $table->smallInteger('IBD_ARX')->nullable(true);
            $table->text('DOP_INFO')->nullable(true);
            $table->string('SHTRIH_KOD',100)->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('v_d_alls');
    }
};
