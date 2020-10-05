<?php

use App\Models\ResumeDesign;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CreateResumeDesignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resume_designs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes('deleted_at');
        });

        $designs = [
            [
                'id' => Str::uuid(),
                'name' => 'Golden Standard',
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Functional',
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Combination',
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Recruiter',
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Sidebar',
            ],
        ];

        ResumeDesign::insert($designs);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resume_designs');
    }
}
