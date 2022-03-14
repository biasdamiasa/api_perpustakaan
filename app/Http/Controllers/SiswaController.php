<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Siswa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = DB::table('siswa')->join('kelas', 'siswa.id_kelas', '=', 'kelas.id')
                                   ->select('siswa.*', 'kelas.nama_kelas')
                                   ->get();

        return response()->json($siswa);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_siswa' => 'required',
            'jk' => 'required',
            'tgl_lahir' => 'required',
            'alamat' => 'required',
            'id_kelas' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors());
        }

        $siswa = Siswa::create([
            'nama_siswa' => $request->nama_siswa,
            'jk' => $request->jk,
            'tgl_lahir' => $request->tgl_lahir,
            'alamat' => $request->alamat,
            'id_kelas' => $request->id_kelas
        ]);

        if($siswa) {
            return response()->json(['status' => 1]);
        } else {
            return response()->json(['status' => 0]);
        }
    }

    public function show($id)
    {
        $siswa = DB::table('siswa')->join('kelas', 'siswa.id_kelas', '=', 'kelas.id')                                   
                                   ->select('siswa.*', 'kelas.nama_kelas')
                                   ->where('siswa.id' , '=', $id)
                                   ->first();
                                   
        return response()->json($siswa);
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'nama_siswa' => 'required',
                'tgl_lahir' => 'required',
                'jk' => 'required',
                'alamat' => 'required',
                'id_kelas' => 'required'
            ]
        );

        if($validator->fails()) {
            return response()->json($validator->errors());
        }

        $siswa = Siswa::find($id);
        $siswa->update($request->all());

        if($siswa) {
            return response()->json(['status' => 1]);
        }
        else {
            return response()->json(['status' => 0]);
        }
    }

    public function destroy($id)
    {
        $siswa = Siswa::find($id);
        $siswa->delete();

        if($siswa) {
            return response()->json(['status' => 1]);
        }
        else {
            return response()->json(['status' => 0]);
        }
    }    
}
