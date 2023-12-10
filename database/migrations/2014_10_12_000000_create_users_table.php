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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->integer('level')->nullable(false)->default(0);
            $table->float('exp')->nullable(false)->default(0);
            $table->float('exp_next_level')->nullable(false)->default(50);
            $table->decimal('coins', 10, 2)
                ->nullable(false)
                ->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('powerup_limit')->default(1)->nullable(false);
            $table->integer('coin_limit')->default(50)->nullable(false);
            $table->integer('active_powerup_limit')->default(1)->nullable(false);
            $table->integer('rebirth')->default(0)->nullable(false);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
