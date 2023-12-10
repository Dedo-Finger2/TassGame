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
        Schema::create('upgrades', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->nullable(false)->unique();
            $table->string('description', 255)->nullable(true);
            $table->integer('level')->nullable(false);
            $table->float('multiplier')->nullable(false);
            $table->float('action_value')->nullable(false);
            $table->float('price', 10, 2)->nullable(false);
            $table->string('image')->nullable(true);
            $table->integer('buy_limit')->nullable(false);
            $table->boolean('can_buy')->nullable(false)->default(true);
            $table->float('price_multiplier_per_buy')->default(1.2)->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('upgrades');
    }
};
