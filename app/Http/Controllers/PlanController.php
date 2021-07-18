<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Plan;

class PlanController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req) {
        $data['anggarans'] = DB::table('anggarans')->where('id_user', auth()->user()->id)->get();
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

        $data['plans'] = DB::table('plans')
                ->leftJoin('anggarans', 'plans.id_anggaran', '=', 'anggarans.id')
                ->where('plans.id_user', auth()->user()->id)
                ->where('bulan', $bulan)
                ->where('tahun', $tahun)
                ->select('plans.*', 'anggarans.nama')
                ->get();
        $data['total_rencana'] = DB::table('plans')
                ->where('plans.id_user', auth()->user()->id)
                ->where('bulan', $bulan)
                ->where('tahun', $tahun)
                ->sum('total');
        
        $bln_anggaran = DB::table('anggarans')
                ->where('anggarans.id_user', auth()->user()->id)
                ->whereMonth('histories.created_at', $bulan)
                ->whereYear('histories.created_at', $tahun)
                ->leftJoin('histories', 'anggarans.id', '=', 'histories.id_anggaran')
                ->selectRaw('anggarans.id, anggarans.nama, SUM(histories.jumlah) as jumlah')
                ->groupBy('anggarans.id')
                ->get();

        $data['total_realisasi'] = 0;
        foreach ($data['plans'] as $i) {
            $i->realisasi = 0;
            foreach ($bln_anggaran as $j) {
                if ($i->id_anggaran == $j->id) {
                    $data['total_realisasi'] += $j->jumlah;
                    $i->realisasi = $j->jumlah;
                }
            }
        }
        
        $data['bln_anggaran'] = DB::table('anggarans')
                ->where('anggarans.id_user', auth()->user()->id)
                ->whereMonth('histories.created_at', $bulan)
                ->whereYear('histories.created_at', $tahun)
                ->leftJoin('histories', 'anggarans.id', '=', 'histories.id_anggaran')
                ->selectRaw('anggarans.nama, SUM(histories.jumlah) as jumlah')
                ->groupBy('anggarans.id')
                ->get();
        
        $data['bln_keluar'] = DB::table('histories')
                ->where('histories.id_user', auth()->user()->id)
                ->where('kategori', 'keluar')
                ->whereMonth('created_at', $bulan)
                ->whereYear('created_at', $tahun)
                ->sum('jumlah');

        $data['js'] = [
            '/plan.js',
        ];

        return view('plan.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $data['anggarans'] = DB::table('anggarans')->where('id_user', auth()->user()->id)->get();
        $data['tahun'] = range(date('Y'), 2020);
        $data['bulan'] = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $data['js'] = [
            '/plan.js',
        ];
        return view('plan.form', $data);
    }

    public function option() {
        $data = DB::table('anggarans')->where('id_user', auth()->user()->id)->get();

        echo json_encode($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $data = [];
        foreach ($request->id_anggaran as $key => $value) {
            $data = [
                'id_user' => auth()->user()->id,
                'bulan' => $request->bulan,
                'tahun' => $request->tahun,
                'id_anggaran' => $request->id_anggaran[$key],
                'jumlah' => $request->jumlah[$key],
                'frekuensi' => $request->frekuensi[$key],
                'satuan' => $request->satuan[$key],
                'total' => $request->total[$key],
            ];
            Plan::create($data);
        }
        return redirect()->route('plan.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
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
        $total = 0;
        $days = cal_days_in_month(CAL_GREGORIAN, $request->bulan, $request->tahun);

        if ($request->satuan == "Sehari") {
            $total = $request->jumlah * $request->frekuensi * $days;
        } elseif ($request->satuan == "Seminggu") {
            $total = $request->jumlah * $request->frekuensi * 4;
        } else {
            $total = $request->jumlah * $request->frekuensi;
        }
        $data = [
            'id_anggaran' => $request->id_anggaran,
            'jumlah' => $request->jumlah,
            'frekuensi' => $request->frekuensi,
            'satuan' => $request->satuan,
            'total' => $total,
        ];
        Plan::where('id', $id)->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        Plan::where('id', $id)->delete();
        return redirect()->route('plan.index');
    }

}
