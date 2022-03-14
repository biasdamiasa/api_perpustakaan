<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Pinjam;
use App\Kembali;

use Carbon\Carbon;

class KembaliController extends Controller
{

    public function index()
    {
        $kembali = DB::table('kembali')->leftJoin('pinjam', 'kembali.id_pinjam' , '=' , 'pinjam.id')
                                       ->leftJoin('siswa' , 'pinjam.id_siswa' , '=' , 'siswa.id')
                                       ->select('kembali.*' , 'siswa.nama_siswa')
                                       ->get();
                                       
        return response()->json($kembali);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_pinjam' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors());
        }

        $cek = Kembali::where('id_pinjam', $request->id_pinjam);

        if($cek->count() == 0) {
            $pinjam = Pinjam::where('id', $request->id_pinjam)->first();
            $tgl_sekarang = Carbon::now()->format('Y-m-d');
            $tgl_kembali = new Carbon($pinjam->tgl_kembali);

            $denda_per_hari = 1000;

            if(strtotime($tgl_sekarang) > strtotime($tgl_kembali)) {
                $jumlah_hari = $tgl_kembali->diff($tgl_sekarang)->days;
                $denda = $jumlah_hari * $denda_per_hari;
            }
            else {
                $denda = 0;
            }

            $kembali = Kembali::create([
                'id_pinjam' => $request->id_pinjam,
                'tgl_kembali' => $tgl_sekarang,
                'denda' => $denda
            ]);

            if($kembali) {
                return response()->json(['status' => 1 , 'pesan' => 'Berhasil kembali']);
            } 
            else {
                return response()->json(['status' => 0 , 'pesan' => 'Gagal kembali']);
            }
        }
        else {
            return response()->json(['status' => 0 , 'pesan' => 'Buku sudah kembali']);
        }
    }
}