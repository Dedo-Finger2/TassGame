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
        Schema::create('remaining_powerups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_inventory_id')->nullable(true)->constrained('user_inventories');
            $table->foreignId('powerup_id')->nullable(true)->constrained('powerups');
            $table->integer('remaining_uses')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('remaining_powerups');
    }
};
