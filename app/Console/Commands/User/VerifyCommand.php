<?php

namespace App\Console\Commands\User;

use Illuminate\Console\Command;

class VerifyCommand extends Command
{
    protected $signature = 'user:verify {email}';

    protected $description = 'Verify new user (my custom!)';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('email for verify: ' . $this->argument('email'));
        return true;
    }
}
