<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * pcat: 1 = Student, 2 = Faculty, 3 = Administrative Personnel,
     *       4 = Contractual/Job Order Personnel, 5 = Visitor/Guest
     */
    protected $tables = ['patientvisits', 'patientreferral'];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->tables as $table) {
            // Some databases don't have pcat on every table (e.g. patientreferral)
            if (Schema::hasColumn($table, 'pcat')) {
                DB::statement("ALTER TABLE {$table} MODIFY pcat ENUM('1','2','3','4','5') NULL");
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->tables as $table) {
            if (Schema::hasColumn($table, 'pcat')) {
                DB::statement("ALTER TABLE {$table} MODIFY pcat ENUM('1','2','3') NULL");
            }
        }
    }
};
