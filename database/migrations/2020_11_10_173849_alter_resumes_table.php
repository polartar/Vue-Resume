<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterResumesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('resumes', function (Blueprint $table) {
            $table->uuid('user_phone_id')->nullable()->index()->after('pdf_url');
            $table->uuid('user_email_id')->nullable()->index()->after('pdf_url');
            $table->uuid('user_address_id')->nullable()->index()->after('pdf_url');

            $table->dropColumn('user_phone_ids');
            $table->dropColumn('user_email_ids');
            $table->dropColumn('user_address_ids');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('resumes', function (Blueprint $table) {
            $table->dropColumn('user_phone_id');
            $table->dropColumn('user_email_id');
            $table->dropColumn('user_address_id');

            $table->json('user_address_ids')->nullable();
            $table->json('user_phone_ids')->nullable();
            $table->json('user_email_ids')->nullable();
        });
    }
}
