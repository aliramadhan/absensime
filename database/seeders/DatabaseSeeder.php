<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

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
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@catering.pahlawandesignstudio.com',
            'password' => Hash::make('qweqweqwe'),
            'role' => 'Admin',
            'number_phone' => '0822',
            'code_number' => 'ADM0001',
            'address' => 'Null',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        DB::table('users')->insert([
            'name' => 'Manager Divisi A',
            'email' => 'manager@absensi.com',
            'password' => Hash::make('qweqweqwe'),
            'role' => 'Manager',
            'number_phone' => '0822123',
            'code_number' => 'MNG0001',
            'address' => 'Null',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);/*
        DB::table('users')->insert([
            'name' => 'Catering 1',
            'email' => 'catering1@cateringme.com',
            'password' => Hash::make('qweqweqwe'),
            'role' => 'Catering',
            'number_phone' => '082236646621',
            'code_number' => 'CTR0001',
            'address' => 'Null',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);*/
        DB::table('users')->insert([
            'name' => 'Employee 1',
            'email' => 'employee1@cateringme.com',
            'password' => Hash::make('qweqweqwe'),
            'role' => 'Employee',
            'number_phone' => '082236646623',
            'code_number' => 'EMP0001',
            'address' => 'Null',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);/*
        DB::table('menus')->insert([
            'menu_code' => 'MNU0001',
            'catering_id' => 2,
            'name' => 'Nasi Pecel',
            'desc' => 'Nasi Pecel Mantap',
            'price' => 20000,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        DB::table('menus')->insert([
            'menu_code' => 'MNU0002',
            'catering_id' => 2,
            'name' => 'Gado-gado',
            'desc' => 'Gado gado Mantap',
            'price' => 20000,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);/*
        DB::table('photo_menus')->insert([
            'menu_id' => 1,
            'file' => 'images/photo-menu/MNU0001/nasi-pecel_1.jpg',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        DB::table('photo_menus')->insert([
            'menu_id' => 1,
            'file' => 'images/photo-menu/MNU0001/nasi-pecel_2.jpg',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        DB::table('photo_menus')->insert([
            'menu_id' => 2,
            'file' => 'images/photo-menu/MNU0002/gado-gado_1.jpg',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        DB::table('photo_menus')->insert([
            'menu_id' => 2,
            'file' => 'images/photo-menu/MNU0002/gado-gado_2.jpg',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);*/
    }
}
