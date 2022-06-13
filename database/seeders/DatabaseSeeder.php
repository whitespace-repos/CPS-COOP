<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $user = User::create([
                                    'phone' => 1234567890 ,
                                    'name' => 'Admin Coop' ,
                                    'email' => 'admin@coop.com',
                                    'password' => Hash::make('1234567890'),
                                    'decrypt' => '1234567890'
                ]);

        //
        DB::table('roles')->insert([
            [
                'created_at' => \Carbon\Carbon::now() ,
                'updated_at' => \Carbon\Carbon::now() ,
                'guard_name' => 'web' ,
                'name' => 'Admin'
            ],[
                'created_at' => \Carbon\Carbon::now() ,
                'updated_at' => \Carbon\Carbon::now() ,
                'guard_name' => 'web' ,
                'name' => 'Supplier'
            ],[
                'created_at' => \Carbon\Carbon::now() ,
                'updated_at' => \Carbon\Carbon::now() ,
                'guard_name' => 'web' ,
                'name' => 'Employee'
            ]
        ]);

        DB::table('setting_groups')->insert([
            "group" => "Weight Unit",
            "slug"  => "weight_unit",
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        $user->assignRole(['Admin','Supplier']);
    }
}
