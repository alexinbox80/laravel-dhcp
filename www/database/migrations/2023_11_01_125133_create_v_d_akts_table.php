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
        Schema::create('v_d_akts', function (Blueprint $table) {
            $table->id();
            $table->integer('ID_VD')->nullable(false);
            $table->integer('ID_DOC')->nullable(false);
            $table->string('N_DOC',25)->nullable(false);
            $table->dateTime('DT_DOC')->nullable(true);
            $table->binary('F_DOC')->nullable(true);
            $table->dateTime('DT_RESH')->nullable(true);
            $table->integer('RESH')->nullable(true);
            $table->integer('KEM_RESH')->nullable(true);
            $table->integer('ISP_RESH')->nullable(true);
            $table->dateTime('DT_ISP_RESH')->nullable(true);
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
        Schema::dropIfExists('v_d_akts');
    }
};
