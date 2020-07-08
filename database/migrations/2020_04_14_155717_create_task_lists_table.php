<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_lists', function (Blueprint $table) {
            $table->id('task_list_id');
            $table->string('task_list_name');
            $table->foreignId('task_list_owner')->default(0)->nullable();
            $table->timestamps();

            $table->foreign('task_list_owner')
                ->references('id')
                ->on('users')
                ->onUpdate('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('task_lists', function(Blueprint $table) {
            $table->dropForeign(['task_list_owner']);
        });
        Schema::dropIfExists('task_lists');
    }
}
