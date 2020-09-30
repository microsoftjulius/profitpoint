<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investments', function (Blueprint $table) {
            $table->id();
            $table->integer('created_by');
            $table->integer('amount');
            $table->string('phone_number');
            $table->enum('type',['mobile money','bitcoin'])->default('mobile money');
            $table->enum('status',['successful','initiated','failed'])->default('initiated');
            $table->string('transaction_id')->nullable();
            $table->text('status_explanation')->nullable();
            $table->string('memo')->nullable();
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
        Schema::dropIfExists('investments');
    }
}
