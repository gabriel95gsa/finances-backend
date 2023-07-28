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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('description', 255);
            $table->unsignedBigInteger('recurrent_expense_id')->nullable();
            $table->double('default_value', 9,2)->default(0);
            $table->string('period_date', 7);
            $table->integer('due_day')->nullable();
            $table->timestamps();

            $table->foreign('recurrent_expense_id')->references('id')->on('recurrent_expenses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropForeign('expenses_recurrent_expense_id_foreign');
        });

        Schema::dropIfExists('expenses');
    }
};
