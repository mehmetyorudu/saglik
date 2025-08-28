<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_answers', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // InnoDB motorunu kullanır
            $table->id();
            $table->foreignId('user_test_attempt_id')->constrained()->onDelete('cascade'); // Hangi denemeye ait
            $table->foreignId('question_id')->constrained()->onDelete('cascade'); // Hangi soru
            $table->foreignId('answer_id')->nullable()->constrained()->onDelete('cascade'); // Kullanıcının seçtiği cevap (null olabilir, boş bırakılırsa)
            $table->boolean('is_correct')->default(false); // Kullanıcının cevabı doğru mu?
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
        Schema::dropIfExists('user_answers');
    }
}
