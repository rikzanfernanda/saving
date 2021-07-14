<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller {

    public function index() {

        return view('auth.forgot-password');
    }

    public function postEmail(Request $request) {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $token = Str::random(64);

        DB::table('password_resets')->insert(
                ['email' => $request->email, 'token' => $token, 'created_at' => Carbon::now()]
        );
        $data = [
            'token' => $token
        ];

        $kirim = Mail::to($request->email)->send(new SendMail($data));
        var_dump($kirim);
        die();
        return redirect()->route('home')->with('message', 'We have e-mailed your password reset link!');
    }

    public function getPassword($token) {

        return view('auth.reset', ['token' => $token]);
    }

    public function updatePassword(Request $request) {

        $request->validate([
            'password' => 'required|string'
        ]);

        $updatePassword = DB::table('password_resets')
                ->where('token', $request->token)
                ->first();

        if (!$updatePassword)
            return back()->withInput()->with('error', 'Invalid token!');

        $user = User::where('email', $updatePassword->email)
                ->update(['password' => bcrypt($request->password)]);

        DB::table('password_resets')->where(['email' => $updatePassword->email])->delete();

        return redirect()->route('home')->with('message', 'Your password has been changed!');
    }

}
