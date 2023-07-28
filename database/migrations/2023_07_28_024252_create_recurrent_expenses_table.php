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
        Schema::create('recurrent_expenses', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->double('default_value', 9, 2);
            $table->double('limit_value', 9, 2)->nullable();
            $table->integer('due_day')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recurrent_expenses');
    }
};
