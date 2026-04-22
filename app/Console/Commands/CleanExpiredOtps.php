<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CleanExpiredOtps extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clean-expired-otps';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up expired OTP codes from the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $deletedCount = \App\Models\Otp::cleanup();

        $this->info("Cleaned up {$deletedCount} expired OTP codes.");
    }
}
