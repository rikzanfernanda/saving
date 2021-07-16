<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Feedback;
use Illuminate\Support\Str;

class FeedbackController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        if (auth()->user()->id_role == 1) {
            $data['css'] = [
                '/datatables.min.css'
            ];
            $data['js'] = [
                '/datatables.min.js',
                '/feedback-admin.js',
            ];

            $data['jumlah'] = DB::table('feedback')->count();

            return view('feedback.admin-index', $data);
        }
        $data['js'] = [
            '/feedback.js'
        ];
        $data['feedbacks'] = DB::table('feedback')->where('id_user', auth()->user()->id)->get();

        return view('feedback.index', $data);
    }

    public function dt() {
        $data = DB::table('feedback')
                ->join('users', 'feedback.id_user', '=', 'users.id', 'left outer')
                ->selectRaw('feedback.*, if(isnull(feedback.id_user), feedback.nama, users.nama ) nama')
//                ->select('feedback.*', 'users.nama as nama_user')
                ->get();
        foreach ($data as $value) {
            $value->komentar = Str::limit($value->komentar, 100, '...');
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
            'komentar' => $request->komentar,
        ];

        if (auth()->user()->id_role == 1) {
            $data = [
                'nama' => $request->nama,
                'komentar' => $request->komentar,
            ];
        }

        $store = Feedback::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $data = DB::table('feedback')->where('id', $id)->first();
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
            'komentar' => $request->komentar,
        ];
        if (auth()->user()->id_role == 1) {
            $data = [
                'nama' => $request->nama,
                'komentar' => $request->komentar,
            ];
        }
        return Feedback::where('id', $id)->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        return Feedback::where('id', $id)->delete();
    }

}
