<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_cases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('section_id')->unsigned()->comment('ID of the section');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('CASCADE');
            $table->string('testcase_summary',2000)->comment('Test case summary');
            $table->string('description',2000)->comment('Test case description')->nullable();
            $table->string('filename',100)->comment('Uploaded filename')->nullable();
            $table->integer('status')->default(1)->comment('Status if the record is active');
            $table->integer('created_by')->nullable()->comment('Who created the record');
            $table->integer('updated_by')->nullable()->comment('Who last updated the record');
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
        Schema::dropIfExists('test_cases');
    }
}
