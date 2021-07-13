<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Bantuan;
use App\Models\Tanggapan;

class BantuanController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req) {
        if (auth()->user()->id_role == 1) {
            $data['js'] = [
                '/bantuan-admin.js',
            ];

            $data['bantuans'] = DB::table('bantuans')
                    ->leftJoin('users', 'bantuans.id_user', '=', 'users.id')
                    ->select('bantuans.*', 'users.nama', 'users.email')
                    ->orderBy('updated_at', 'desc')
                    ->get();

            if ($req->filter) {
                $data['bantuans'] = DB::table('bantuans')
                        ->whereNotIn('bantuans.id', DB::table('tanggapans')->pluck('id_bantuan'))
                        ->leftJoin('users', 'bantuans.id_user', '=', 'users.id')
                        ->select('bantuans.*', 'users.nama', 'users.email')
                        ->orderBy('updated_at', 'desc')
                        ->get();
            }

            foreach ($data['bantuans'] as $bt) {
                $bt->tanggapan = DB::table('tanggapans')
                        ->where('id_bantuan', $bt->id)
                        ->get();
            }

            return view('bantuan.admin-index', $data);
        }

        $data['js'] = [
            '/bantuan.js'
        ];
        $data['bantuans'] = DB::table('bantuans')->where('id_user', auth()->user()->id)
                ->leftJoin('users', 'bantuans.id_user', '=', 'users.id')
                ->select('bantuans.*', 'users.nama', 'users.email')
                ->get();

        foreach ($data['bantuans'] as $bt) {
            $bt->tanggapan = DB::table('tanggapans')
                    ->where('id_bantuan', $bt->id)
                    ->get();
        }

        return view('bantuan.index', $data);
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
            'pertanyaan' => $request->pertanyaan,
        ];

        $store = Bantuan::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $data = DB::table('bantuans')->where('id', $id)->first();
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
            'pertanyaan' => $request->pertanyaan,
        ];
        return Bantuan::where('id', $id)->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        Bantuan::where('id', $id)->delete();
        Tanggapan::where('id_bantuan', $id)->delete();
    }

}
