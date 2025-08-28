<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTestAttemptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_test_attempts', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // InnoDB motorunu kullanır
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Testi çözen kullanıcı
            $table->foreignId('test_id')->constrained()->onDelete('cascade'); // Hangi test
            $table->integer('score')->default(0); // Doğru cevap sayısı
            $table->integer('total_questions')->default(0); // Toplam soru sayısı
            $table->integer('correct_answers')->default(0);
            $table->integer('incorrect_answers')->default(0);
            $table->timestamp('attempt_date')->useCurrent(); // Deneme tarihi
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
        Schema::dropIfExists('user_test_attempts');
    }
}
