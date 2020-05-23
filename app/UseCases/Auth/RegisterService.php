<?php

namespace App\UseCases\Auth;

use App\Models\User;
use App\Http\Requests\Auth\RegisterRequest;
use App\Mail\Auth\VerifyMail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Events\Dispatcher;

class RegisterService
{
    private $mailer;
    private $dispatcher;

    public function __construct(Mailer $mailer, Dispatcher $dispatcher)
    {
        $this->mailer = $mailer;
        $this->dispatcher = $dispatcher;
    }


    public function register(RegisterRequest $request): void
    {
        $user = User::register(
            $request['name'],
            $request['email'],
            $request['password']
        );

        // 1-2 отправка сообщения и порождение события
        // сообщение отправилось все равно и без строки ниже
        //Mail::to($user->email)->send(new VerifyMail($user));

        // это событие вызывает отправку письма! теперь можно его перехватить
        //event(new Registered($user));

        // заменили на
        $this->dispatcher->dispatch(new Registered($user));
        //$this->mailer->to($user->email)->send(new VerifyMail($user)); // т.е. сообщение отправляется после порождения события
    }

    public function verify($id): void
    {
        /** @var User $user */
        $user = User::findOrFail($id);
        $user->verify();
    }

    public function unverify($id): void
    {
        /** @var User $user */
        $user = User::findOrFail($id);
        $user->unverify();
    }
}