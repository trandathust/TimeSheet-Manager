<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimesheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timesheets', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id');
            $table->date('date_work');
            $table->integer('ctv_id');
            $table->integer('manager_id');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('total_hour');
            $table->string('effective');
            $table->string('description');
            $table->string('confirm_hour')->nullable();
            $table->string('confirm_effective')->nullable();
            $table->boolean('status_manager')->default(0);
            $table->string('user_last_change');
            $table->softDeletes();
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
        Schema::dropIfExists('timesheets');
    }
}
