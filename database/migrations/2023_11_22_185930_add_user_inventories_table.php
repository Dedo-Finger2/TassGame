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
        Schema::create('user_inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->nullable(true)->constrained('items');
            $table->foreignId('user_id')->nullable(false)->constrained('users');
            $table->foreignId('powerup_id')->nullable(true)->constrained('powerups');
            $table->foreignId('upgrade_id')->nullable(true)->constrained('upgrades');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_inventories');
    }
};
