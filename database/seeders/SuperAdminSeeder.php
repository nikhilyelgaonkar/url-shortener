<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    
    public function run(): void
    {
        $email = 'superadmin@example.com';

        $exists = User::where('email',$email)->exists();

        if($exists){
            return ;
        }


        DB::insert(
            'INSERT INTO users
            (name, email, password, company_id, role,
             email_verified_at, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)',
            [
                'Super Admin',
                $email,
                Hash::make('SuperAdmin@123'),
                null,
                'superadmin',
                now(),
                now(),
                now()
            ]
        );
    }
}
