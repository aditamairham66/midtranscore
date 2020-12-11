<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMidtranscorePayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('midtranscore_payment', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('code_payment', 255)->nullable();
            $table->string('method_payment', 255)->nullable();
            $table->decimal('ammount_payment', 22, 2)->nullable();
            $table->string('status_payment', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('midtranscore_payment');
    }
}
