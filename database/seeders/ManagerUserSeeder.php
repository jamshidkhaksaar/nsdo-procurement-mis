<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ManagerUserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrNew(['email' => 'manager@nsdo.org']);
        $user->name = 'Procurement Manager';
        $user->role = 'manager';
        $user->password = Hash::make('password123');
        $user->save();

        $this->command->info('Manager user created/updated successfully.');
        $this->command->info('Email: manager@nsdo.org');
        $this->command->info('Password: password123');
        $this->command->info('Role: manager');
    }
}
