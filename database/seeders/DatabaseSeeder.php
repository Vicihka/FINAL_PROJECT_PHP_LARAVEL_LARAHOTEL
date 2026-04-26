<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@larahotel.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        $this->call([
            RoomSeeder::class,
        ]);
    }
}
