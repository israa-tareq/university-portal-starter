<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Seeds the login accounts for the portal.
 *
 * Kept separate from the main DatabaseSeeder so you can (re)create just the
 * users on their own:
 *
 *     php artisan portal:seed-auth          (friendly wrapper)
 *     php artisan db:seed --class=UserSeeder
 *
 * It is also called by DatabaseSeeder, so `migrate:fresh --seed` creates
 * these accounts too.
 */
class UserSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $users = [
            ['name' => 'Portal Admin', 'email' => 'admin@uni.edu', 'password' => 'password'],
            ['name' => 'Demo Student', 'email' => 'student@uni.edu', 'password' => 'password'],
        ];

        foreach ($users as $user) {
            // updateOrInsert keeps this re-runnable without duplicate emails.
            DB::table('users')->updateOrInsert(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'password' => Hash::make($user['password']),
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            );
        }
    }
}
