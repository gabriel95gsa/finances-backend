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
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('expenses_category_id')->nullable();
            $table->string('description', 255);
            $table->double('default_value', 9, 2);
            $table->double('limit_value', 9, 2)->nullable();
            $table->integer('due_day')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('expenses_category_id')->references('id')->on('expenses_categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recurrent_expenses', function (Blueprint $table) {
            $table->dropForeign('recurrent_expenses_user_id_foreign');
            $table->dropForeign('recurrent_expenses_expenses_category_id_foreign');
        });

        Schema::dropIfExists('recurrent_expenses');
    }
};
