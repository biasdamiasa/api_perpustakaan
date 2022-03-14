<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\DetailPinjam;

class DetailPinjamController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_buku' => 'required',
            'jumlah' => 'required'
        ]);

        if($validator->fails()) {
            return Response()->json($validator->errors());
        }

        $detail = DetailPinjam::create([
            'id_pinjam' => $request->id_pinjam,
            'id_buku' => $request->id_buku,
            'jumlah' => $request->jumlah
        ]);

        if($detail) {
            return response()->json(['status' => 1]);
        }
        else {
            return response()->json(['status' => 0]);
        }
    }

    public function show($id_pinjam)
    {
        $detail = DB::table('detail_pinjam')->join('buku', 'detail_pinjam.id_buku', '=', 'buku.id')
                                            ->select('detail_pinjam.*', 'buku.judul')
                                            ->where('id_pinjam', $id_pinjam)
                                            ->get();
        
        return response()->json($detail);
    }
}
