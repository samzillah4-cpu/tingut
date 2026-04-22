<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckExpiredSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-expired-subscriptions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for expired subscriptions and notify users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredSubscriptions = \App\Models\Subscription::where('status', 'active')
            ->where('end_date', '<', now())
            ->get();

        foreach ($expiredSubscriptions as $subscription) {
            // Update status to expired
            $subscription->update(['status' => 'expired']);

            // Send notification
            $subscription->user->notify(new \App\Notifications\SubscriptionExpired($subscription));
        }

        $this->info('Checked '.$expiredSubscriptions->count().' expired subscriptions.');
    }
}
