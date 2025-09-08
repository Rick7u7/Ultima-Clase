<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class InsertUndefinedGeneroIntoGenerosTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('genero')) {
            $exists = DB::table('genero')->where('nombre', 'undefined')->exists();

            if (! $exists) {
                DB::table('genero')->insert([
                    'nombre' => 'undefined',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down()
    {
        DB::table('genero')->where('nombre', 'undefined')->delete();
    }
}
