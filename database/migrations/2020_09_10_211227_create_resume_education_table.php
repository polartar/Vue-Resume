<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResumeEducationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resume_education', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('resume_id')->index();
            $table->string('school_name');
            $table->enum('type', ['high school', 'trade / vocation', 'community college', 'university']);
            $table->string('degree_received')->nullable();
            $table->string('field_of_study')->nullable();
            $table->boolean('completed');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('currently_studying');
            $table->json('resume_description_ids')->nullable();
            $table->timestamps();
            $table->softDeletes('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resume_education');
    }
}
