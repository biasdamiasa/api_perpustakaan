<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Buku;
use Illuminate\Support\Facades\Validator;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::all()->toArray();
        return $buku;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'judul' => 'required',
                'pengarang' => 'required',
                'deskripsi' => 'required'
            ]
        );

        if($validator->fails()) {
            return response()->json($validator->errors());
        } 

        $buku = Buku::create([
            'judul' => $request->judul,
            'pengarang' => $request->pengarang,
            'deskripsi' => $request->deskripsi
        ]);

        if($buku) {
            return response()->json(['status' => 1]);
        }
        else {
            return response()->json(['status' => 0]);
        }
    }

    public function show($id)
    {
        $buku = Buku::find($id);
        return response()->json($buku);
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'judul' => 'required',
                'pengarang' => 'required',
                'deskripsi' => 'required'
            ]
        );

        if($validator->fails()) {
            return response()->json($validator->errors());
        }

        $buku = Buku::find($id);
        $buku->update($request->all());

        if($buku) {
            return response()->json(['status' => 1]);
        }
        else {
            return response()->json(['status' => 0]);
        }
    }

    public function destroy($id)
    {
        $buku = Buku::find($id);
        $buku->delete();

        if($buku) {
            return response()->json(['status' => 1]);
        }
        else {
            return response()->json(['status' => 0]);
        }
    }
}
