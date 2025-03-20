<?php

namespace Database\Seeders;

use App\Models\Photo;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('users')->insert([
           'name'=>'Tom',
           'is_active'=>1,
           'email_verified_at'=>now(),
           'email'=>'syntraprogrammeurs@gmail.com',
           'photo_id'=>Photo::inRandomOrder()->first()->id,
           'password'=>Hash::make('12345678'),
           'created_at'=>now(),
           'updated_at'=>now(),
        ]);
        DB::table('users')->insert([
            'name'=>'Tim',
            'is_active'=>1,
            'email_verified_at'=>now(),
            'email'=>'timtest@gmail.com',
            'photo_id'=>Photo::inRandomOrder()->first()->id,
            'password'=>Hash::make('12345678'),
            'created_at'=>now(),
            'updated_at'=>now(),
        ]);
        User::factory(500)->create();
        //User::factory()->count(50)->create();
    }
}
