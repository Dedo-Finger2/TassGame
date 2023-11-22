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
        Schema::create('sub_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->nullable(false)->constrained('tasks');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('importance_id')->constrained('importances');
            $table->foreignId('difficulty_id')->constrained('difficulties');
            $table->foreignId('urgence_id')->constrained('urgences');

            $table->string('name')->nullable(false);
            $table->string('description')->nullable(false);
            $table->decimal('coins', 10, 2)->nullable(false);
            $table->float('exp')->nullable(false);
            $table->dateTime('completed_at')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_tasks');
    }
};
