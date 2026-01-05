<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrNew(['email' => 'admin@nsdo.org']);
        $user->name = 'Admin User';
        $user->role = 'admin';
        $user->password = Hash::make('password123');
        $user->save();

        $this->command->info('Admin user created/updated successfully.');
        $this->command->info('Email: admin@nsdo.org');
        $this->command->info('Password: password123');
        $this->command->info('Role: admin');
    }
}
