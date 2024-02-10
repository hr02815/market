<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'hunainbhimani@gmail.com')->first();

        if(!$user){

            User::create([
                'name' => 'Hunain',
                'email' => 'hunainbhimani@gmail.com',
                'role' => 'seller',
                'password' => Hash::make('password'),

            ]);
        }
    }
}
