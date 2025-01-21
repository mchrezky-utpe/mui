<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MstUserSeeder extends Seeder
{
    public function run()
    {
        DB::table('mst_user')->insert([
            [
                'username' => 'admin',
                'name' => 'Administrator',
                'prefix' => 'Mr.',
                'password' => md5('123'), // Hash password dengan MD5
                'flag_active' => true,
                'created_by' => 'system',
                'updated_by' => 'system',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
