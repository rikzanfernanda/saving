<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Tanggapan;

class TanggapanController extends Controller {

    public function store(Request $request) {
        $data = [
            'id_bantuan' => $request->id_bantuan,
            'tanggapan' => $request->tanggapan,
        ];
        $store = Tanggapan::create($data);
    }
    
    public function show($id) {
        echo json_encode(DB::table('tanggapans')->where('id', $id)->first());
    }
    
    public function update(Request $request, $id) {
        $data = [
            'tanggapan' => $request->tanggapan,
        ];
        return Tanggapan::where('id', $id)->update($data);
    }
    
    public function destroy($id) {
        return Tanggapan::where('id', $id)->delete();
    }

}
