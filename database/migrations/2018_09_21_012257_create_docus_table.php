<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('docus', function (Blueprint $table) {
            $table->increments('docu_id');
            $table->string('username');
            $table->string('recipient');
            $table->string('sender');
            $table->string('sender_add');
            $table->string('subject');
            $table->string('addressee');
            $table->string('cc_addressee');
            $table->string('final_action_stat');
            $table->string('final_action_remarks');
            $table->date('final_action_date');
            $table->string('final_action_by');
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
        Schema::dropIfExists('docus');
    }
}
