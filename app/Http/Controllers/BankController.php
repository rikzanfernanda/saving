<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Bank;
use App\Models\History;

class BankController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $data['banks'] = DB::table('banks')->where('id_user', auth()->user()->id)->get();
        $data['jumlah'] = DB::table('banks')->where('id_user', auth()->user()->id)->count();
        $data['anggarans'] = DB::table('anggarans')->where('id_user', auth()->user()->id)->get();
        $data['css'] = [
            '/datatables.min.css'
        ];
        $data['js'] = [
            '/datatables.min.js',
            '/bank.js'
        ];
        $data['total'] = DB::table('banks')->where('id_user', auth()->user()->id)->sum('saldo');
        return view('bank.index', $data);
    }

    public function dt() {
        $data = DB::table('banks')->where('id_user', auth()->user()->id)->get();
        foreach ($data as $dt) {
//            $dt->tindakan = '<a href="' . route('pelanggan.bank.destroy', $dt->id) . '" class="mr-2"><i class="fas fa-trash-alt"></i></a> <a href="' . route('pelanggan.bank.edit', $dt->id) . '"><i class="fas fa-pen-alt"></i></a>';
            $dt->saldo = moneyFormat($dt->saldo);
        }
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
        $data = [
            'id_user' => auth()->user()->id,
            'nama' => $request->nama,
            'saldo' => $request->saldo,
        ];

        $store = Bank::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $data = DB::table('banks')->where('id', $id)->first();
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
            'saldo' => $request->saldo,
        ];
        return Bank::where('id', $id)->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        return Bank::where('id', $id)->delete();
    }

    // pemasukan
    public function masuk(Request $req) {
        $jumlah = $req->jumlah;
        $id = $req->bank;
        if (!isset($id))
            return redirect()->route('bank.index');

        $bank = DB::table('banks')->where('id', $id)->first();
        DB::table('banks')->where('id', $id)->update([
            'saldo' => $bank->saldo + $jumlah
        ]);

        $data = [
            'id_user' => auth()->user()->id,
            'kegiatan' => 'Uang masuk sebesar ' . moneyFormat($jumlah) . ' ke bank ' . $bank->nama,
            'kategori' => 'masuk',
            'jumlah' => $jumlah,
            'id_bank' => $id
        ];

        History::create($data);
        if (isset($req->route))
            return redirect()->route('bank.index');
        return redirect()->route('dashboard');
    }

    // pemasukan
    public function keluar(Request $req) {
        $jumlah = $req->jumlah;
        $id = $req->bank;
        $id_anggaran = $req->anggaran;
        if (!isset($id))
            return redirect()->route('bank.index');

        $anggaran = DB::table('anggarans')->where('id', $id_anggaran)->first();
        $bank = DB::table('banks')->where('id', $id)->first();
        DB::table('banks')->where('id', $id)->update([
            'saldo' => $bank->saldo - $jumlah
        ]);
        $agr = isset($anggaran)? " untuk anggaran $anggaran->nama": '';

        $data = [
            'id_user' => auth()->user()->id,
            'kegiatan' => 'Uang keluar sebesar ' . moneyFormat($jumlah) . ' dari bank ' . $bank->nama . $agr,
            'kategori' => 'keluar',
            'jumlah' => $jumlah,
            'id_bank' => $id,
            'id_anggaran' => $id_anggaran
        ];
        History::create($data);
        if (isset($req->route))
            return redirect()->route('bank.index');
        return redirect()->route('dashboard');
    }

}
