<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimesheetNotifiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timesheet_notifies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('timesheet_id');
            $table->foreign('timesheet_id')->references('id')->on('timesheets')
                  ->onDelete('cascade');
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')
                  ->onDelete('cascade');
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
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
        Schema::dropIfExists('timesheet_notifies');
    }
}
