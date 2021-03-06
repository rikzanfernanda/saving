<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;

class HomeController extends Controller {

    public function __construct() {
        $this->middleware('auth')->except([
            'index',
            'login',
            'redirectToProvider',
            'handleProviderCallback',
            'loginPage',
            'registrasiPage',
        ]);
    }

    public function index() {
        return view('home');
    }

    public function loginPage() {
        return view('login');
    }
    
    public function registrasiPage() {
        return view('registrasi');
    }

    public function login(Request $request) {
        $request->validate([
            'email' => ['required', 'exists:users,email'],
            'password' => ['required'],
        ]);
        
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];
        $remember_me = $request->has('remember') ? true : false;

        Auth::attempt($data, $remember_me);

        if (Auth::check()) {
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('login.page')->withErrors('Coba lagi! Password Anda salah');
        }
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('home');
    }

    public function dashboard() {
        switch (Auth::user()->id_role) {
            case 1:
                $data['css'] = [
                    '/datatables.min.css'
                ];
                $data['js'] = [
                    '/admin-dashboard.js',
                    '/datatables.min.js'
                ];

                $data['users'] = DB::table('users')->where('id_role', 3)->whereMonth('created_at', date("m"))->orderBy('created_at', 'desc')->limit(5)->get();
                $data['feedbacks'] = DB::table('feedback')
                        ->join('users', 'feedback.id_user', '=', 'users.id', 'left outer')
                        ->selectRaw('feedback.*, if(isnull(feedback.id_user), feedback.nama, users.nama ) nama')
                        ->limit(5)
                        ->get();
                $data['bantuans'] = DB::table('bantuans')
                        ->whereNotIn('bantuans.id', DB::table('tanggapans')->pluck('id_bantuan'))
                        ->leftJoin('users', 'bantuans.id_user', '=', 'users.id')
                        ->count();
                return view('admin-dashboard', $data);
                break;
            case 2:
                echo 'admin';
                break;
            default:
                $data['banks'] = DB::table('banks')->where('id_user', Auth::user()->id)->get();
                $data['anggarans'] = DB::table('anggarans')->where('id_user', Auth::user()->id)->get();
                $data['tahun'] = range(date('Y'), 2020);
                $data['bulan'] = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                $data['total_masuk'] = DB::table('histories')
                        ->where('histories.id_user', auth()->user()->id)
                        ->where('kategori', 'masuk')
                        ->sum('jumlah');
                $data['total_keluar'] = DB::table('histories')
                        ->where('histories.id_user', auth()->user()->id)
                        ->where('kategori', 'keluar')
                        ->sum('jumlah');
                $data['bln_masuk'] = DB::table('histories')
                        ->where('histories.id_user', auth()->user()->id)
                        ->where('kategori', 'masuk')
                        ->whereMonth('created_at', date('m'))
                        ->sum('jumlah');
                $data['bln_keluar'] = DB::table('histories')
                        ->where('histories.id_user', auth()->user()->id)
                        ->where('kategori', 'keluar')
                        ->whereMonth('created_at', date('m'))
                        ->sum('jumlah');
                $data['thn_masuk'] = DB::table('histories')
                        ->where('histories.id_user', auth()->user()->id)
                        ->where('kategori', 'masuk')
                        ->whereYear('created_at', date('Y'))
                        ->sum('jumlah');
                $data['thn_keluar'] = DB::table('histories')
                        ->where('histories.id_user', auth()->user()->id)
                        ->where('kategori', 'keluar')
                        ->whereYear('created_at', date('Y'))
                        ->sum('jumlah');
                $data['total_save'] = $data['thn_masuk'] - $data['thn_keluar'];
                $data['bln_save'] = $data['bln_masuk'] - $data['bln_keluar'];
                $data['uang_anggaran'] = DB::table('anggarans')
                        ->where('anggarans.id_user', Auth::user()->id)
                        ->leftJoin('histories', 'anggarans.id', '=', 'histories.id_anggaran')
                        ->selectRaw('anggarans.nama, SUM(histories.jumlah) as jumlah')
                        ->groupBy('anggarans.id')
                        ->limit(5)
                        ->get();
                $data['bln_uang_anggaran'] = DB::table('anggarans')
                        ->where('anggarans.id_user', Auth::user()->id)
                        ->whereMonth('histories.created_at', date('m'))
                        ->leftJoin('histories', 'anggarans.id', '=', 'histories.id_anggaran')
                        ->selectRaw('anggarans.nama, SUM(histories.jumlah) as jumlah')
                        ->groupBy('anggarans.id')
                        ->limit(5)
                        ->get();
                $data['bln_uang_masuk'] = DB::table('banks')
                        ->where('banks.id_user', auth()->user()->id)
                        ->where('histories.kategori', 'masuk')
                        ->whereMonth('histories.created_at', date('m'))
                        ->whereYear('histories.created_at', date("Y"))
                        ->leftJoin('histories', 'banks.id', '=', 'histories.id_bank')
                        ->selectRaw('banks.nama, SUM(histories.jumlah) as jumlah')
                        ->groupBy('banks.id')
                        ->limit(5)
                        ->get();
                $data['plans'] = DB::table('plans')
                        ->where('plans.id_user', Auth::user()->id)
                        ->where('plans.bulan', date('m'))
                        ->where('plans.tahun', date("Y"))
                        ->leftJoin('anggarans', 'plans.id_anggaran', '=', 'anggarans.id')
                        ->selectRaw('anggarans.nama, SUM(plans.total) as total')
                        ->groupBy('anggarans.nama')
                        ->get();
                $data['total_rencana'] = DB::table('plans')
                        ->where('plans.id_user', auth()->user()->id)
                        ->where('bulan', date('m'))
                        ->where('tahun', date("Y"))
                        ->sum('total');
                $data['histories'] = DB::table('histories')->where('id_user', auth()->user()->id)->orderBy('created_at', 'desc')->limit(5)->get();
                $data['css'] = [
                    '/datatables.min.css',
                    '/select2.min.css',
                    '/slick.css',
                    '/slick-theme.css'
                ];
                $data['js'] = [
                    '/slick.js',
                    '/user-dashboard.js',
                    '/datatables.min.js',
                    '/select2.min.js'
                ];
                return view('user-dashboard', $data);
                break;
        }
    }

    public function akun() {
        $data['akun'] = DB::table('users')->where('id', Auth::user()->id)->first();
        switch (Auth::user()->id_role) {
            case 1:
                return view('admin-akun', $data);
                break;
            case 2:
                echo 'admin';
                break;
            default:
                return view('user-akun', $data);
                break;
        }
    }

    public function petunjuk() {
        return view('petunjuk');
    }

    public function redirectToProvider($driver) {
        return Socialite::driver($driver)->redirect();
    }

    public function handleProviderCallback($driver) {
        try {

            $user = Socialite::driver($driver)->user();

            $finduser = User::where('provider_id', $user->id)->first();

            if ($finduser) {

                Auth::login($finduser);

                return redirect()->intended('dashboard');
            } else {
                if (User::where('email', $user->email)->first()) {
                    return redirect()->route('login.page')->with('gagal', 'Email sudah terdaftar');
                }
                $newUser = User::create([
                            'id_role' => 3,
                            'nama' => $user->name,
                            'email' => $user->email,
                            'provider' => $driver,
                            'provider_id' => $user->id,
                            'password' => ''
                ]);

                Auth::login($newUser);

                return redirect()->intended('dashboard');
            }
        } catch (Exception $e) {
//            dd($e->getMessage());
            return redirect()->route('login.page')->with('gagal', 'Gunakan Login yang Lain');
        }
    }

}
