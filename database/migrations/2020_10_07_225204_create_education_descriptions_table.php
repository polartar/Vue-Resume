<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEducationDescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('education_descriptions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('resume_education_id')->nullable();
            $table->text('description')->nullable();
            $table->enum('type', ['unorderedlist', 'ordered list', 'paragraph'])->nullable();
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
        Schema::dropIfExists('education_descriptions');
    }
}
