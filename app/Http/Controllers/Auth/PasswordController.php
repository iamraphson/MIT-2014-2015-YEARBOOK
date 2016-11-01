<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('guest');
    }

    public function sendResetLinkEmail(Request $request){
        $this->validate($request, [
            'username' => 'required',
        ]);

        $user = User::where('username', $request->input('username'))->first();
        if(!is_null($user)){
            list($email, $token) = $this->findOrCreateUser($user);
            $this->sendResetMail($email, $token);
            return redirect()->back()->with('status', 'We have e-mailed your password reset link!');
        } else {
            return redirect()->back()->with('warning', '<strong>'.$request->input('username') . '</strong> Not Found');
        }
    }

    protected function sendResetMail($email, $token){
        Mail::send('auth.emails.password',
            ['token' => $token, 'email' => $email],
            function($message) use($email, $token) {
                $message->to($email, $token)
                    ->subject('Your Password Reset Link');
        });
    }

    protected function findOrCreateUser($user){
        $resetUser = DB::table('password_resets')->where('email',  $user->email)->get();
        if ($resetUser){
            return array($resetUser[0]->email, $resetUser[0]->token);
        }
        $token = (new AuthController())->getToken();
        DB::table('password_resets')->insert(
            ['email' => $user->email, 'token' => $token]
        );
        return array($user->email, $token);
    }
}
