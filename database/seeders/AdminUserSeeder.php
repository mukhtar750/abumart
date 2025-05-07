<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin; // Or App\Models\User if using the same table
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        if (!Admin::where('email', 'admin@example.com')->exists()) {
            $tempPassword = Str::random(12);

            Admin::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make($tempPassword),
                'has_changed_password' => false, // THIS IS THE CRUCIAL PART THAT WAS MISSING
            ]);

            echo "Temporary Admin Password: " . $tempPassword . "\n";
        }
    }
}