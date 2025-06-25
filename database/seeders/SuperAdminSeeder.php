<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            'name'            => 'Super Admin',
            'username'        => 'superadmin',
            'email'           => 'superadmin@example.com',
            'password'        => Hash::make('password123'), // Change this!
            'role'            => 'superadmin',
            'expires_at'      => Carbon::now()->addDays(7),
            'is_admin'        => true,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);
    }
}
