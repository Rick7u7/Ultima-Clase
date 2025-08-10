<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class InsertCommonRoleIntoRolesTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('roles')) {
            $exists = DB::table('roles')->where('nombre', 'common')->exists();

            if (! $exists) {
                DB::table('roles')->insert([
                    'nombre' => 'common', // ← este es el campo correcto
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);                
            }
        }
    }

    public function down()
    {
        DB::table('roles')->where('nombre', 'common')->delete();
    }
};