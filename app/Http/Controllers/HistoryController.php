<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\History;
use Barryvdh\DomPDF\Facade as PDF;

class HistoryController extends Controller {

    public function index() {
        $data['css'] = [
            '/datatables.min.css'
        ];
        $data['js'] = [
            '/history.js',
            '/datatables.min.js'
        ];
        return view('history.index', $data);
    }

    public function dt() {
        $data = DB::table('histories')->where('id_user', auth()->user()->id)->limit(1000)->orderBy('created_at', 'desc')->get();
        foreach ($data as $dt) {
            $dt->jumlah = moneyFormat($dt->jumlah);
        }
        echo json_encode($data);
    }

    public function laporan(Request $req) {
        $data['tahun'] = range(date('Y'), 2020);
        $data['bulan'] = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $data['total'] = DB::table('banks')->where('id_user', auth()->user()->id)->sum('saldo');
        $data['banks'] = DB::table('banks')->where('id_user', auth()->user()->id)->get();
        $bulan = intval(date('m')) == 1 ? 12 : intval(date('m')) - 1;
        $tahun = intval(date('m')) == 1 ? intval(date('Y')) - 1 : intval(date('Y'));

        if ($req->bulan && $req->tahun) {
            $bulan = $req->bulan;
            $tahun = $req->tahun;
        }
        $data['bulan_ini'] = $bulan;
        $data['tahun_ini'] = $tahun;

        $data['masuk'] = DB::table('histories')
                ->where('histories.id_user', auth()->user()->id)
                ->where('kategori', 'masuk')
                ->whereMonth('histories.created_at', "$bulan")
                ->whereYear('histories.created_at', "$tahun")
                ->leftJoin('banks', 'histories.id_bank', '=', 'banks.id')
                ->select('histories.*', 'banks.nama as bank')
                ->get();
        $data['total_masuk'] = DB::table('histories')
                ->where('histories.id_user', auth()->user()->id)
                ->where('kategori', 'masuk')
                ->whereMonth('histories.created_at', "$bulan")
                ->whereYear('histories.created_at', "$tahun")
                ->leftJoin('banks', 'histories.id_bank', '=', 'banks.id')
                ->sum('jumlah');
        $data['keluar'] = DB::table('histories')
                ->where('histories.id_user', auth()->user()->id)
                ->where('kategori', 'keluar')
                ->whereMonth('histories.created_at', "$bulan")
                ->whereYear('histories.created_at', "$tahun")
                ->leftJoin('banks', 'histories.id_bank', '=', 'banks.id')
                ->leftJoin('anggarans', 'histories.id_anggaran', '=', 'anggarans.id')
                ->select('histories.*', 'banks.nama as bank', 'anggarans.nama as anggaran')
                ->get();
        $data['total_keluar'] = DB::table('histories')
                ->where('histories.id_user', auth()->user()->id)
                ->where('kategori', 'keluar')
                ->whereMonth('histories.created_at', "$bulan")
                ->whereYear('histories.created_at', "$tahun")
                ->leftJoin('banks', 'histories.id_bank', '=', 'banks.id')
                ->sum('jumlah');

        return view('history.laporan', $data);
    }

    public function download(Request $req) {
        $bulan_nama = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $data['bulan_ini'] = $bulan_nama[$req->bulan - 1];
        $data['tahun_ini'] = $req->tahun;
        $bulan = intval(date('m')) == 1 ? 12 : intval(date('m')) - 1;
        $tahun = intval(date('m')) == 1 ? intval(date('Y')) - 1 : intval(date('Y'));
        if ($req->bulan && $req->tahun) {
            $bulan = $req->bulan;
            $tahun = $req->tahun;
        }
        $data['total'] = DB::table('banks')->where('id_user', auth()->user()->id)->sum('saldo');
        $data['banks'] = DB::table('banks')->where('id_user', auth()->user()->id)->get();
        $data['masuk'] = DB::table('histories')
                ->where('histories.id_user', auth()->user()->id)
                ->where('kategori', 'masuk')
                ->whereMonth('histories.created_at', "$bulan")
                ->whereYear('histories.created_at', "$tahun")
                ->leftJoin('banks', 'histories.id_bank', '=', 'banks.id')
                ->select('histories.*', 'banks.nama as bank')
                ->get();
        $data['total_masuk'] = DB::table('histories')
                ->where('histories.id_user', auth()->user()->id)
                ->where('kategori', 'masuk')
                ->whereMonth('histories.created_at', "$bulan")
                ->whereYear('histories.created_at', "$tahun")
                ->leftJoin('banks', 'histories.id_bank', '=', 'banks.id')
                ->sum('jumlah');
        $data['keluar'] = DB::table('histories')
                ->where('histories.id_user', auth()->user()->id)
                ->where('kategori', 'keluar')
                ->whereMonth('histories.created_at', "$bulan")
                ->whereYear('histories.created_at', "$tahun")
                ->leftJoin('banks', 'histories.id_bank', '=', 'banks.id')
                ->leftJoin('anggarans', 'histories.id_anggaran', '=', 'anggarans.id')
                ->select('histories.*', 'banks.nama as bank', 'anggarans.nama as anggaran')
                ->get();
        $data['total_keluar'] = DB::table('histories')
                ->where('histories.id_user', auth()->user()->id)
                ->where('kategori', 'keluar')
                ->whereMonth('histories.created_at', "$bulan")
                ->whereYear('histories.created_at', "$tahun")
                ->leftJoin('banks', 'histories.id_bank', '=', 'banks.id')
                ->sum('jumlah');
        $data['histories'] = DB::table('histories')->where('id_user', auth()->user()->id)->get();
//        return view('history.laporan-pdf', $data);
        $pdf = PDF::loadview('history.laporan-pdf', $data);
        return $pdf->download('laporan-bulanan.pdf');
    }

    // chart
    public function chart() {
        $data = DB::table('histories')
                ->selectRaw('month(created_at) as bulan, sum(jumlah) as jumlah')
                ->where('kategori', 'masuk')
                ->where('id_user', auth()->user()->id)
                ->whereRaw('year(created_at)', date("Y"))
                ->groupBy('bulan')
                ->get();
        $data_keluar = DB::table('histories')
                ->selectRaw('month(created_at) as bulan, sum(jumlah) as jumlah')
                ->where('kategori', 'keluar')
                ->where('id_user', auth()->user()->id)
                ->whereRaw('year(created_at)', date("Y"))
                ->groupBy('bulan')
                ->get();
        $chart_pemasukan = [];
        foreach ($data as $dt) {
            if ($dt->bulan == 1) {
                $chart_pemasukan['Januari'] = $dt->jumlah;
            }
            if ($dt->bulan == 2) {
                $chart_pemasukan['Februari'] = $dt->jumlah;
            }
            if ($dt->bulan == 3) {
                $chart_pemasukan['Maret'] = $dt->jumlah;
            }
            if ($dt->bulan == 4) {
                $chart_pemasukan['April'] = $dt->jumlah;
            }
            if ($dt->bulan == 5) {
                $chart_pemasukan['Mei'] = $dt->jumlah;
            }
            if ($dt->bulan == 6) {
                $chart_pemasukan['Juni'] = $dt->jumlah;
            }
            if ($dt->bulan == 7) {
                $chart_pemasukan['Juli'] = $dt->jumlah;
            }
            if ($dt->bulan == 8) {
                $chart_pemasukan['Agustus'] = $dt->jumlah;
            }
            if ($dt->bulan == 9) {
                $chart_pemasukan['September'] = $dt->jumlah;
            }
            if ($dt->bulan == 10) {
                $chart_pemasukan['Oktober'] = $dt->jumlah;
            }
            if ($dt->bulan == 11) {
                $chart_pemasukan['Novermber'] = $dt->jumlah;
            }
            if ($dt->bulan == 12) {
                $chart_pemasukan['Desember'] = $dt->jumlah;
            }
        }

        $chart_pengeluaran = [];
        foreach ($data_keluar as $dt) {
            if ($dt->bulan == 1) {
                $chart_pengeluaran['Januari'] = $dt->jumlah;
            }
            if ($dt->bulan == 2) {
                $chart_pengeluaran['Februari'] = $dt->jumlah;
            }
            if ($dt->bulan == 3) {
                $chart_pengeluaran['Maret'] = $dt->jumlah;
            }
            if ($dt->bulan == 4) {
                $chart_pengeluaran['April'] = $dt->jumlah;
            }
            if ($dt->bulan == 5) {
                $chart_pengeluaran['Mei'] = $dt->jumlah;
            }
            if ($dt->bulan == 6) {
                $chart_pengeluaran['Juni'] = $dt->jumlah;
            }
            if ($dt->bulan == 7) {
                $chart_pengeluaran['Juli'] = $dt->jumlah;
            }
            if ($dt->bulan == 8) {
                $chart_pengeluaran['Agustus'] = $dt->jumlah;
            }
            if ($dt->bulan == 9) {
                $chart_pengeluaran['September'] = $dt->jumlah;
            }
            if ($dt->bulan == 10) {
                $chart_pengeluaran['Oktober'] = $dt->jumlah;
            }
            if ($dt->bulan == 11) {
                $chart_pengeluaran['Novermber'] = $dt->jumlah;
            }
            if ($dt->bulan == 12) {
                $chart_pengeluaran['Desember'] = $dt->jumlah;
            }
        }
        echo json_encode(['pemasukan' => $chart_pemasukan, 'pengeluaran' => $chart_pengeluaran]);
    }
    
    public function restore($id) {
        $history = DB::table('histories')->where('id', $id)->first();
        $bank = DB::table('banks')->where('id', $history->id_bank)->first();
        if ($history->kategori == "keluar"){
            DB::table('banks')->where('id', $history->id_bank)->update(['saldo' => $bank->saldo + $history->jumlah]);
        } else {
            DB::table('banks')->where('id', $history->id_bank)->update(['saldo' => $bank->saldo - $history->jumlah]);
        }
        
        return History::where('id', $id)->delete();
    }

}
