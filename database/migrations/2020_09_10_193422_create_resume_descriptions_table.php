<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResumeDescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resume_descriptions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('resume_work_experience_id');
            $table->string('description');
            $table->enum('type', ['unorderedlist', 'ordered list', 'paragraph']);
            $table->integer('sort_order')->default(0);
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
        Schema::dropIfExists('resume_descriptions');
    }
}
