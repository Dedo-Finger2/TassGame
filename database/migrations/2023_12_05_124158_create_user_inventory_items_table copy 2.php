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
        Schema::create('user_inventory_powerups', function (Blueprint $table) {
            $table->foreignId('user_inventory_id')->constrained('user_inventories');
            $table->foreignId('powerup_id')->constrained('powerups');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_inventory_powerups');
    }
};
