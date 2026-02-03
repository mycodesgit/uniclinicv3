<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('college', function (Blueprint $table) {
            $table->id();
            $table->string('campus');
            $table->string('college_abbr');
            $table->string('college_name');
            $table->timestamps();
        });

        $now = Carbon::now();
        DB::table('college')->insert([
            ['campus' => 'MC', 'college_abbr' => 'CAF', 'college_name' => 'COLLEGE OF AGRICULTURE AND FORESTRY', 'created_at' => $now, 'updated_at' => $now],
            ['campus' => 'MC', 'college_abbr' => 'CAS', 'college_name' => 'COLLEGE OF ARTS AND SCIENCES', 'created_at' => $now, 'updated_at' => $now],
            ['campus' => 'MC', 'college_abbr' => 'CBM', 'college_name' => 'COLLEGE OF BUSINESS AND MANAGEMENT', 'created_at' => $now, 'updated_at' => $now],
            ['campus' => 'MC', 'college_abbr' => 'CCS', 'college_name' => 'COLLEGE OF COMPUTER STUDIES', 'created_at' => $now, 'updated_at' => $now],
            ['campus' => 'MC', 'college_abbr' => 'CJE', 'college_name' => 'COLLEGE OF CRIMINAL JUSTICE EDUCATION', 'created_at' => $now, 'updated_at' => $now],
            ['campus' => 'MC', 'college_abbr' => 'COE', 'college_name' => 'COLLEGE OF ENGINEERING', 'created_at' => $now, 'updated_at' => $now],
            ['campus' => 'MC', 'college_abbr' => 'CTE', 'college_name' => 'COLLEGE OF TEACHER EDUCATION', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('college');
    }
};
