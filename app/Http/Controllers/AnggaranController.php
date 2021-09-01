<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Anggaran;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class AnggaranController extends Controller {

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
        $data['bln_anggaran'] = DB::table('anggarans')
                ->where('anggarans.id_user', auth()->user()->id)
                ->where('histories.kategori', 'keluar')
                ->whereMonth('histories.created_at', $bulan)
                ->whereYear('histories.created_at', $tahun)
                ->leftJoin('histories', 'anggarans.id', '=', 'histories.id_anggaran')
                ->selectRaw('anggarans.nama, SUM(histories.jumlah) as jumlah')
                ->groupBy('anggarans.id')
                ->get();
        $data['total_keluar'] = DB::table('histories')
                ->where('histories.id_user', auth()->user()->id)
                ->where('kategori', 'keluar')
                ->sum('jumlah');
        $data['bln_keluar'] = DB::table('histories')
                ->where('histories.id_user', auth()->user()->id)
                ->where('kategori', 'keluar')
                ->whereMonth('created_at', $bulan)
                ->whereYear('created_at', $tahun)
                ->sum('jumlah');
        $data['jumlah'] = DB::table('anggarans')->where('id_user', auth()->user()->id)->count();
        $data['css'] = [
            '/datatables.min.css'
        ];
        $data['js'] = [
            '/datatables.min.js',
            '/anggaran.js'
        ];

        return view('anggaran.index', $data);
    }

    public function dt() {
//        $data = DB::table('anggarans')->where('id_user', auth()->user()->id);
        $data = DB::table('anggarans')
                ->where('anggarans.id_user', auth()->user()->id)
                ->leftJoin('histories', 'anggarans.id', '=', 'histories.id_anggaran')
                ->selectRaw('anggarans.*, SUM(histories.jumlah) as total')
                ->groupBy('anggarans.id');
        return Datatables::of($data)
                        ->filterColumn('id', function ($query, $keyword) {
                            $query->whereRaw("CONCAT(id,'-',id) like ?", ["%{$keyword}%"]);
                        })
                        ->addColumn('tindakan', function ($row) {
                            $btn = '<a href="' . route('anggaran.show', $row->id) . '" class="text-green" data-edit="' . $row->id . '" data-toggle="modal" data-target="#modalEditAnggaran"><i class="fas fa-edit"></i></a> <a href="' . route('anggaran.destroy', $row->id) . '" class="ml-2 text-red" data-hapus="' . $row->id . '"><i class="fas fa-trash"></i></a>';
                            return $btn;
                        })
                        ->rawColumns(['tindakan'])
                        ->addIndexColumn()
                        ->editColumn('total', '{{moneyFormat($total)}}')
                        ->make(true);
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
        $data = [];
        foreach ($request->nama as $key => $value) {
            $data = [
                'id_user' => auth()->user()->id,
                'nama' => $request->nama[$key],
            ];
            $store = Anggaran::create($data);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $data = DB::table('anggarans')->where('id', $id)->first();
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
        ];
        return Anggaran::where('id', $id)->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        return Anggaran::where('id', $id)->delete();
    }

    public function option(Request $req) {
        $data = DB::table('anggarans')->where('id_user', auth()->user()->id)->get();
        if (isset($req->q)) {
            $data = DB::table('anggarans')->where('id_user', auth()->user()->id)->where('nama', 'LIKE', '%' . $req->q . '%')->get();
        }

        echo json_encode($data);
    }

}
