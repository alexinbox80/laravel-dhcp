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
        Schema::create('v_d_mains', function (Blueprint $table) {
            $table->id();
            $table->integer('ID_MAIN')->nullable(false);
            $table->integer('N_KUSP')->nullable(false);
            $table->dateTime('DT_KUSP')->nullable(false);
            $table->string('N_UD',200)->nullable(true);
            $table->dateTime('DT_UD')->nullable(true);
            $table->integer('N_AD')->nullable(true);
            $table->dateTime('DT_AD')->nullable(true);
            $table->smallInteger('OVD_DELA')->nullable(false);
            $table->dateTime('DT_REG')->nullable(true);
            $table->dateTime('DT_IZM')->nullable(true);
            $table->smallInteger('SHPOLZ')->nullable(true);
            $table->smallInteger('SHPOLZ1')->nullable(true);
            $table->smallInteger('IBD_ARX')->nullable(true);
            $table->text('DOP_INFO')->nullable(true);
            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('v_d_mains');
    }
};

