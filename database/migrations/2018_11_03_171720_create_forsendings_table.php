<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForsendingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forsendings', function (Blueprint $table) {
            $table->increments('send_id');
            $table->integer('docu_id');
            $table->integer('sender_id');
            $table->string('receiver_id');
            $table->date('date_deadline')->default('1111-11-11');
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
        Schema::dropIfExists('forsendings');
    }
}
