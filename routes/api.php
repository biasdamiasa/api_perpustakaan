<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post("login", "AuthController@login");

Route::group(["middleware" => ["jwt.verify"]], function() {

    Route::post("logout", "AuthController@logout");
    Route::post("checkToken", "AuthController@checkToken");

    Route::post("/insert_kelas", "KelasController@store");
    
    Route::get("/getsiswakelas", "SiswaController@index");
    Route::post("/insert_siswa", "SiswaController@store");
    Route::put("/update_siswa/{id}", "SiswaController@update");
    Route::delete("/delete_siswa/{id}", "SiswaController@destroy");
    
    Route::apiResource("siswa", "SiswaController");
    Route::apiResource("kelas", "KelasController");
    Route::apiResource("buku", "BukuController");
    Route::apiResource("pinjam", "PinjamController");
    Route::put("pinjam/status/{id_pinjam}", "PinjamController@updateStatus");
    
    Route::post("pinjam_buku", "PinjamController@store");
    Route::post("tambah_item/{id}", "DetailPinjamController@store");
    Route::post("mengembalikan_buku", "KembaliController@store");
    
    Route::get("detail/{id_pinjam}", "DetailPinjamController@show");
    Route::post("detail", "DetailPinjamController@store");
    
    Route::get('kembali', "KembaliController@index");
    Route::post('kembali', "KembaliController@store");



});


