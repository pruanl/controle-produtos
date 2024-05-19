<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = 'admin@admin.com';

        $user = User::where('email',$email)->first();

        if(!$user){
            User::create([
                'name' => 'Admin User',
                'email' => $email,
                'password' => Hash::make('admin'),
            ]);
        }


    }
}
