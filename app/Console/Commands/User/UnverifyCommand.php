<?php

namespace App\Console\Commands\User;

use Illuminate\Console\Command;
use App\UseCases\Auth\RegisterService;
use App\Models\User;

class UnverifyCommand extends Command
{
    protected $signature = 'user:unverify {email}';

    protected $description = 'Unverify user email';

    private $service;

    public function __construct(RegisterService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    public function handle(): bool
    {
        $email = $this->argument('email');

        /** @var User $user */
        if (!$user = User::where('email', $email)->first()) {
            $this->error('Undefined user with email ' . $email);
            return false;
        }

        try {
            $this->service->unverify($user->id);
        } catch (\DomainException $e) {
            $this->error($e->getMessage());
            return false;
        }

        $this->info('User is successfully unverified');
        return true;
    }
}
