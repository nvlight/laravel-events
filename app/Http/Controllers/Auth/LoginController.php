<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Sms\SmsSender;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Auth\LoginRequest;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
    //use ThrottlesLogins;

    protected $redirectTo = 'event';
    private $sms;

    public function __construct(SmsSender $sms)
    {
        $this->middleware('guest')->except('logout');
        $this->sms = $sms;
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function authenticated(Request $request, $user)
    {
        if ($user->status !== User::STATUS_ACTIVE) {
            $this->guard()->logout();
            return back()->with('error', 'You need to confirm your account. Please check your email.');
        }
        return redirect()->intended($this->redirectPath());
    }

    public function login(LoginRequest $request)
    {
//        if ($this->hasTooManyLoginAttempts($request)) {
//            $this->fireLockoutEvent($request);
//            $this->sendLockoutResponse($request);
//        }

        $authenticate = Auth::attempt(
            $request->only(['email', 'password']),
            $request->filled('remember')
        );

        if ($authenticate) {
            $request->session()->regenerate();
            $this->clearLoginAttempts($request);
            $user = Auth::user();

            if ($user->isWait()) {
                Auth::logout();
                return back()->with('error', 'You need to confirm your account. Please check your email.');
            }
            //return redirect('/');
                //->intended(route('event'));
                //->intended(route('cabinet'));
                //->intended(route('/'));

            if ($user->isPhoneAuthEnabled()) {
                Auth::logout();
                $token = (string)random_int(10000, 99999);
                $request->session()->put('auth', [
                    'id' => $user->id,
                    'token' => $token,
                    'remember' => $request->filled('remember'),
                ]);
                $this->sms->send($user->phone, 'Login code: ' . $token);
                return redirect()->route('login.phone');
            }

            return redirect()->intended(route('event.index'));
        }

        return redirect()->intended($this->redirectPath());

        $this->incrementLoginAttempts($request);

        throw ValidationException::withMessages(['email' => [trans('auth.failed')]]);
    }

    public function phone()
    {
        return view('auth.phone');
    }

    public function verify(Request $request)
    {
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            $this->sendLockoutResponse($request);
        }

        $this->validate($request, [
            'token' => 'required|string',
        ]);

        if (!$session = $request->session()->get('auth')) {
            throw new BadRequestHttpException('Missing token info.');
        }

        /** @var User $user */
        $user = User::findOrFail($session['id']);

        if ($request['token'] === $session['token']) {
            $request->session()->flush();
            $this->clearLoginAttempts($request);
            Auth::login($user, $session['remember']);
            return redirect()->intended(route('event.index'));
        }

        $this->incrementLoginAttempts($request);

        throw ValidationException::withMessages(['token' => ['Invalid auth token.']]);
    }

    public function logout(Request $request)
    {
        Auth::guard()->logout();
        $request->session()->invalidate();
        return redirect('/'); //->route('home');
    }

    protected function username()
    {
        return 'email';
    }
}
