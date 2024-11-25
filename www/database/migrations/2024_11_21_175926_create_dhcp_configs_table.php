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
        Schema::create('dhcp_configs', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('CAB')->nullable();
            $table->string('F')->nullable();
            $table->string('I')->nullable();
            $table->string('O')->nullable();
            $table->string('COMP', 128)->unique();
            $table->string('IP', 15)->unique();
            $table->string('OLD_IP', 15)->nullable();
            $table->string('MAC', 17)->unique();
            $table->text('INFO')->nullable();
            $table->boolean('FLAG')->default(true)->nullable();
            $table->dateTime('DT_REG')->nullable();
            $table->dateTime('DT_UPD')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dhcp_configs');
    }
};
