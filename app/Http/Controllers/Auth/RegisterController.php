<?php

namespace App\Http\Controllers\Auth;

use App\Mail\Auth\VerifyMail;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\UseCases\Auth\RegisterService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;
use App\Http\Requests\Auth\RegisterRequest;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    private $service;
    protected $redirectTo = '/';

    public function __construct(RegisterService $service)
    {
        $this->middleware('guest');
        $this->service = $service;
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:1', 'confirmed'],
        ]);
    }

    public function verify($token)
    {
        if (!$user = User::where('verify_token', $token)->first()) {
            return redirect()->route('login')
                ->with('error', 'Sorry your link cannot be identified.');
        }

        try {
            $user->verify();
            $this->service->verify($user->id); // email_verified_at - a
            return redirect()->route('login')->with('success', 'Your e-mail is verified. You can now login.');
        } catch (\DomainException $e) {
            //logger($e->getMessage());
            return redirect()->route('login')->with('error', $e->getMessage());
        }

    }

    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'verify_token' => Str::random(),
            'status' => User::STATUS_WAIT,
        ]);

        //Mail::to($user->email)->send(new VerifyMail($user));

        return $user;
    }

    public function register(RegisterRequest $request)
    {
        $this->service->register($request);

        return redirect()->route('login')
            ->with('success', 'Check your email and click on the link to verify.');
    }

    protected function registered(Request $request, $user)
    {
        $this->guard()->logout();

        return redirect()->route('login')
            ->with('success', 'Check your email and click on the link to verify.');
    }
}
