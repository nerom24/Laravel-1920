<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        User::truncate();
        DB::table('role_user')->truncate();

        $adminRole = Role::where('name', 'admin')->first();
        $authorRole = Role::where('name', 'author')->first();
        $userRole = Role::where('name', 'user')->first();

        $yomismo = User::create([
            'name' => 'Juan Carlos Moreno',
            'email' => 'nerom24@gmail.com',
            'password' => Hash::make('casitachica')
            ]
        );

        $admin = User::create([
            'name' => 'Administrador Name',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password')
            ]
        );

        $author = User::create([
            'name' => 'Author Name',
            'email' => 'author@gmail.com',
            'password' => Hash::make('password')
            ]
        );

        $user = User::create([
            'name' => 'User Name',
            'email' => 'user@gmail.com',
            'password' => Hash::make('password')
            ]
        );

        $yomismo->roles()->attach($adminRole);
        $admin->roles()->attach($adminRole);
        $author->roles()->attach($authorRole);
        $user->roles()->attach($userRole);

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');


    }
}
