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
        Schema::create('v_d_media', function (Blueprint $table) {
            $table->id();
            $table->integer('ID_VD')->nullable(false);
            $table->integer('ID_ZAP')->nullable(false);
            $table->binary('FILE')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('v_d_media');
    }
};
