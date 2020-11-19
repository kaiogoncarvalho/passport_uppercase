<?php

namespace Laravel\Passport\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Laravel\Passport\Passport;

class PurgeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'passport:purge
                            {--revoked : Only purge revoked tokens and authentication codes}
                            {--expired : Only purge expired tokens and authentication codes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Purge revoked and / or expired tokens and authentication codes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expired = Carbon::now()->subDays(7);

        if (($this->option('revoked') && $this->option('expired')) ||
            (! $this->option('revoked') && ! $this->option('expired'))) {
            Passport::token()->where('REVOKED', 1)->orWhereDate('EXPIRES_AT', '<', $expired)->delete();
            Passport::authCode()->where('REVOKED', 1)->orWhereDate('EXPIRES_AT', '<', $expired)->delete();
            Passport::refreshToken()->where('REVOKED', 1)->orWhereDate('EXPIRES_AT', '<', $expired)->delete();

            $this->info('Purged revoked items and items expired for more than seven days.');
        } elseif ($this->option('revoked')) {
            Passport::token()->where('REVOKED', 1)->delete();
            Passport::authCode()->where('REVOKED', 1)->delete();
            Passport::refreshToken()->where('REVOKED', 1)->delete();

            $this->info('Purged revoked items.');
        } elseif ($this->option('expired')) {
            Passport::token()->whereDate('EXPIRES_AT', '<', $expired)->delete();
            Passport::authCode()->whereDate('EXPIRES_AT', '<', $expired)->delete();
            Passport::refreshToken()->whereDate('EXPIRES_AT', '<', $expired)->delete();

            $this->info('Purged items expired for more than seven days.');
        }
    }
}
