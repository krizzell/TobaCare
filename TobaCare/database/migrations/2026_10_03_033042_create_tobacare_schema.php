<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('reports')) {
            return; // skema sudah diimpor manual lewat pgAdmin
        }

        DB::unprepared(file_get_contents(database_path('sql/tobacare_schema.sql')));
    }

    public function down(): void
    {
        
    }
};