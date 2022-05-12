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
            $table->integer('user_id')->nullable();
            $table->bigInteger('user_code');
            $table->string('user_name');
            $table->integer('role_id');
            $table->integer('department_id');
            $table->integer('position_id');
            $table->integer('contract_type');
            $table->json('timesheet');
            $table->bigInteger('total_salary')->nullable();
            $table->bigInteger('deduction')->nullable();
            $table->string('deduction_reason')->nullable();
            $table->integer('payroll_status')->nullable();
            $table->json('schedule');
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
