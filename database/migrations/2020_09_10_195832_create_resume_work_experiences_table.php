<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResumeWorkExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resume_work_experiences', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('resume_id')->index();
            $table->string('position_title')->nullable();
            $table->string('position_company')->nullable();
            $table->date('position_start_date');
            $table->date('position_end_date')->nullable();
            $table->json('resume_description_ids')->nullable();
            $table->boolean('current_employer');
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
        Schema::dropIfExists('resume_work_experiences');
    }
}
