<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        Role::truncate();

        Role::create(['name' => 'admin', 'description' => 'Todos los privilegios']);
        Role::create(['name' => 'author','description' => 'No todos los privilegios' ]);
        Role::create(['name' => 'user', 'description' => 'Sin privilegios']);

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');


    }
}
