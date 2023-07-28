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
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->string('description', 255);
            $table->unsignedBigInteger('recurrent_income_id')->nullable();
            $table->double('value', 9,2)->default(0);
            $table->string('period_date', 7);
            $table->timestamps();

            $table->foreign('recurrent_income_id')->references('id')->on('recurrent_incomes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incomes', function (Blueprint $table) {
            $table->dropForeign('incomes_recurrent_income_id_foreign');
        });

        Schema::dropIfExists('incomes');
    }
};
