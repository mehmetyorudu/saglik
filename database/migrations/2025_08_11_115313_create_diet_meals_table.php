<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDietMealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diet_meals', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // InnoDB motorunu kullanır
            $table->id();
            $table->foreignId('diet_plan_id')->constrained('diet_plans')->onDelete('cascade');

            $table->unsignedTinyInteger('day_number')->nullable(); // 1..7 (hafta içi)
            $table->enum('meal_type', ['breakfast','snack','lunch','snack2','dinner','supper','other'])->default('breakfast');

            $table->string('title')->nullable();
            $table->text('notes')->nullable();

            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('diet_meals');
    }
}
