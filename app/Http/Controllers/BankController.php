<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Bank;
use App\Models\History;
use App\Models\Anggaran;
use Yajra\DataTables\Facades\DataTables;

class BankController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req) {
        $data['tahun'] = range(date('Y'), 2020);
        $data['bulan'] = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $bulan = intval(date('m'));
        $tahun = intval(date('Y'));
        if ($req->bulan && $req->tahun) {
            $bulan = $req->bulan;
            $tahun = $req->tahun;
        }
        $data['bulan_ini'] = $bulan;
        $data['tahun_ini'] = $tahun;
        $data['bln_bank'] = DB::table('banks')
                ->where('banks.id_user', auth()->user()->id)
                ->where('histories.kategori', 'masuk')
                ->whereMonth('histories.created_at', $bulan)
                ->whereYear('histories.created_at', $tahun)
                ->leftJoin('histories', 'banks.id', '=', 'histories.id_bank')
                ->selectRaw('banks.nama, SUM(histories.jumlah) as jumlah')
                ->groupBy('banks.id')
                ->get();
        $data['bln_masuk'] = DB::table('histories')
                ->where('histories.id_user', auth()->user()->id)
                ->where('kategori', 'masuk')
                ->whereMonth('created_at', $bulan)
                ->whereYear('created_at', $tahun)
                ->sum('jumlah');

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
        $data = DB::table('banks')->where('id_user', auth()->user()->id);

        return Datatables::of($data)
                        ->filterColumn('id', function ($query, $keyword) {
                            $query->whereRaw("CONCAT(id,'-',id) like ?", ["%{$keyword}%"]);
                        })
                        ->addColumn('tindakan', function ($row) {
                            $btn = '<a href="' . route('bank.show', $row->id) . '" class="text-green" data-edit="' . $row->id . '" data-toggle="modal" data-target="#modalEditBank"><i class="fas fa-edit"></i></a> <a href="' . route('bank.destroy', $row->id) . '" class="ml-2 text-red" data-hapus="' . $row->id . '"><i class="fas fa-trash"></i></a>';
                            return $btn;
                        })
                        ->rawColumns(['tindakan'])
                        ->editColumn('saldo', '{{moneyFormat($saldo)}}')
                        ->make(true);
    }

    public function chart() {
        $data = DB::table('banks')->where('id_user', auth()->user()->id)->get();
        $chart = [];
        foreach ($data as $value) {
            $chart[$value->nama] = $value->saldo;
        }

        echo json_encode($chart);
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

    // create pemasukan
    public function createPemasukan() {
        $data['css'] = [
            '/select2.min.css'
        ];
        $data['js'] = [
            '/select2.min.js',
            '/create-pemasukan.js'
        ];
        return view('bank.create-pemasukan', $data);
    }

    // create pengeluaran
    public function createPengeluaran() {
        $data['css'] = [
            '/select2.min.css'
        ];
        $data['js'] = [
            '/select2.min.js',
            '/create-pengeluaran.js'
        ];
        return view('bank.create-pengeluaran', $data);
    }

    // pemasukan
    public function masuk(Request $req) {
        $data = [];
        foreach ($req->jumlah as $key => $value) {
            $jumlah = $req->jumlah[$key];
            $id = $req->bank[$key];
            if (!isset($id))
                return redirect()->route('bank.index');

            $bank = DB::table('banks')->where('id', $id)->first();
            DB::table('banks')->where('id', $id)->update([
                'saldo' => $bank->saldo + $jumlah
            ]);

            $data = [
                'id_user' => auth()->user()->id,
                'kegiatan' => 'Uang masuk sebesar ' . moneyFormat($jumlah) . ' ke ' . $bank->nama,
                'kategori' => 'masuk',
                'jumlah' => $jumlah,
                'id_bank' => $id
            ];

            History::create($data);
        }

        if (isset($req->route))
            return redirect()->route('bank.index');
        return redirect()->route('bank.create.pemasukan');
    }

    // pengeluaran
    public function keluar(Request $req) {
        $data = [];
        foreach ($req->jumlah as $key => $value) {
            $jumlah = $req->jumlah[$key];
            $id = $req->bank[$key];
            $id_anggaran = $req->anggaran[$key];
            if (!isset($id))
                return redirect()->route('bank.index');
            if (Anggaran::find($req->anggaran[$key]) == null) {
                $id_anggaran = Anggaran::create([
                            'id_user' => auth()->user()->id,
                            'nama' => $id_anggaran
                        ])->id;
            }

            $anggaran = DB::table('anggarans')->where('id', $id_anggaran)->first();
            $bank = DB::table('banks')->where('id', $id)->first();
            Bank::where('id', $id)->update([
                'saldo' => $bank->saldo - $jumlah
            ]);
            $agr = isset($anggaran) ? " untuk anggaran $anggaran->nama" : '';

            $data = [
                'id_user' => auth()->user()->id,
                'kegiatan' => 'Uang keluar sebesar ' . moneyFormat($jumlah) . ' dari ' . $bank->nama . $agr,
                'kategori' => 'keluar',
                'jumlah' => $jumlah,
                'id_bank' => $id,
                'id_anggaran' => $id_anggaran
            ];
            History::create($data);
        }

        if (isset($req->route))
            return redirect()->route('bank.index');
        return redirect()->route('bank.create.pengeluaran');
    }

    public function option(Request $req) {
        $data = DB::table('banks')->where('id_user', auth()->user()->id)->get();
        if (isset($req->q)) {
            $data = DB::table('banks')->where('id_user', auth()->user()->id)->where('nama', 'LIKE', '%' . $req->q . '%')->get();
        }

        echo json_encode($data);
    }

}
