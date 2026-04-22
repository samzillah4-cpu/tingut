<?php

namespace App\Console\Commands;

use App\Models\Otp;
use Illuminate\Console\Command;

class ShowLatestOtp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'otp:show {--email= : Filter by email address} {--limit=5 : Number of OTPs to show}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show the latest OTP codes for testing purposes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $query = Otp::query()->latest();

        if ($this->option('email')) {
            $query->where('email', $this->option('email'));
        }

        $otps = $query->limit($this->option('limit'))->get();

        if ($otps->isEmpty()) {
            $this->warn('No OTP codes found.');

            return;
        }

        $this->info('🔐 Latest OTP Codes:');
        $this->table(
            ['Email', 'Code', 'Type', 'Expires', 'Used'],
            $otps->map(function ($otp) {
                return [
                    $otp->email,
                    $otp->code,
                    ucfirst($otp->type),
                    $otp->expires_at->format('M j H:i'),
                    $otp->used ? '✅' : '❌',
                ];
            })
        );

        $this->line('');
        $this->comment('💡 Tip: Use --email=user@example.com to filter by specific email');
    }
}
