<?php

namespace App\Console\Commands;

use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Console\Command;

/**
 * php artisan portal:seed-auth
 *
 *   - with no arguments: seeds the demo login accounts (via UserSeeder).
 *   - with an email + password: creates/updates that one account.
 *
 * Handy for students who forked the project before authentication existed,
 * or who just want a quick account to log in with.
 */
class SeedAuthUsers extends Command
{
    protected $signature = 'portal:seed-auth
                            {email? : Create this single account instead of the demo set}
                            {password? : Password for that account (default: password)}
                            {--name=Portal User : Name for that account}';

    protected $description = 'Seed login account(s) for the portal';

    public function handle(): int
    {
        $email = $this->argument('email');

        // Single custom account.
        if ($email) {
            $password = $this->argument('password') ?: 'password';

            User::updateOrCreate(
                ['email' => $email],
                ['name' => $this->option('name'), 'password' => $password], // hashed by the model cast
            );

            $this->info("Account ready:  {$email}  /  {$password}");

            return self::SUCCESS;
        }

        // Default: the demo accounts.
        $this->call('db:seed', ['--class' => UserSeeder::class, '--force' => true]);

        $this->newLine();
        $this->info('Demo login accounts seeded:');
        $this->line('  admin@uni.edu    / password');
        $this->line('  student@uni.edu  / password');

        return self::SUCCESS;
    }
}
