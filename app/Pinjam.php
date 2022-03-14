<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pinjam extends Model
{
    protected $table = 'pinjam';
    protected $fillable = ['id_siswa', 'tgl_pinjam', 'tgl_kembali', 'status'];
}
