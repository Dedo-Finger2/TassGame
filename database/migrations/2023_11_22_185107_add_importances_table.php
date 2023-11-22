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
        Schema::create('importances', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->nullable(false)->unique();
            $table->string('description', 255)->nullable(true);
            $table->float('exp')->nullable(false);
            $table->decimal('coins', 10, 2)->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('importances');
    }
};
