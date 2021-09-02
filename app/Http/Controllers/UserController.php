<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Bank;
use App\Models\Anggaran;
use App\Models\Feedback;
use App\Models\Bantuan;
use App\Models\Tanggapan;
use App\Models\History;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\Wellcome;

class UserController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $data['css'] = [
            '/datatables.min.css'
        ];
        $data['js'] = [
            '/datatables.min.js',
            '/user.js'
        ];
        $data['jumlah'] = DB::table('users')->where('id_role', 3)->count();
        return view('user.index', $data);
    }

    public function dt() {
        $data = DB::table('users')->where('id_role', 3)->get();

        echo $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $request->validate([
            'email' => 'required|email|unique:users,email',
        ]);
        $data = [
            'nama' => $request->nama,
            'id_role' => 3,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'pekerjaan' => $request->pekerjaan,
            'alamat' => $request->alamat
        ];
        $store = User::create($data);
        if ($store) {
            auth()->user() == null ? Mail::to($request->email)->send(new Wellcome($data)): null;
            return redirect()->route('login.page')->with('message', 'Registrasi berhasil! silakan login');
        } else {
            return redirect()->route('registrasi.page')->withErrors('Registrasi gagal!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $data = DB::table('users')->where('id', $id)->first();
        echo json_encode($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'pekerjaan' => $request->pekerjaan,
            'alamat' => $request->alamat
        ];
        if (isset($request->password)) {
            $data['password'] = bcrypt($request->password);
        }
        User::where('id', $id)->update($data);

        return redirect()->route('akun');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $user = DB::table('users')->where('id', $id)->first();
        if ($user->id_role == 1)
            return back();
        $role = Auth::user()->id_role;
        User::where('id', $id)->delete();
        Bank::where('id_user', $id)->delete();
        Anggaran::where('id_user', $id)->delete();
        Feedback::where('id_user', $id)->update(['id_user' => null, 'nama' => $user->nama]);
        $bantuan = DB::table('bantuans')->where('id_user', $id)->get();
        Bantuan::where('id_user', $id)->delete();
        foreach ($bantuan as $value) {
            Tanggapan::where('id_bantuan', $value->id)->delete();
        }
        History::where('id_user', $id)->delete();
        if ($role == 3) {
            Session::flush();
            return redirect()->route('home');
        }
    }

    // chart
    public function chart() {
        $data = DB::table('users')
                ->selectRaw('month(created_at) as bulan, count(id) as jumlah')
                ->where('id_role', 3)
                ->whereRaw('year(created_at)', date("Y"))
                ->groupBy('bulan')
                ->get();

        $chart = [];
        foreach ($data as $dt) {
            if ($dt->bulan == 1) {
                $chart['Januari'] = $dt->jumlah;
            }
            if ($dt->bulan == 2) {
                $chart['Februari'] = $dt->jumlah;
            }
            if ($dt->bulan == 3) {
                $chart['Maret'] = $dt->jumlah;
            }
            if ($dt->bulan == 4) {
                $chart['April'] = $dt->jumlah;
            }
            if ($dt->bulan == 5) {
                $chart['Mei'] = $dt->jumlah;
            }
            if ($dt->bulan == 6) {
                $chart['Juni'] = $dt->jumlah;
            }
            if ($dt->bulan == 7) {
                $chart['Juli'] = $dt->jumlah;
            }
            if ($dt->bulan == 8) {
                $chart['Agustus'] = $dt->jumlah;
            }
            if ($dt->bulan == 9) {
                $chart['September'] = $dt->jumlah;
            }
            if ($dt->bulan == 10) {
                $chart['Oktober'] = $dt->jumlah;
            }
            if ($dt->bulan == 11) {
                $chart['Novermber'] = $dt->jumlah;
            }
            if ($dt->bulan == 12) {
                $chart['Desember'] = $dt->jumlah;
            }
        }

        echo json_encode($chart);
    }

}
