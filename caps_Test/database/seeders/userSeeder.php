<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Str;

use lluminate\Support\Facades\DB;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i<=10; $i++){
           FacadesDB::table('users')->insert([
                'first_name'=>Str::random(10),
                'middle_name'=>Str::random(10),
                'last_name'=>Str::random(10),
                'email'=>Str::random(20),
                'email_verified_at'=>date('Y-m-d H:i:s'),
                'password'=>Str::random(15),
                'remember_token'=>Str::random(15),
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
            ]);
        }
     
    }
    
}
