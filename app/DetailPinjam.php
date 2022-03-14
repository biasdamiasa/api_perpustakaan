<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailPinjam extends Model
{
    protected $table = 'detail_pinjam';
    protected $fillable = ['id_pinjam', 'id_buku', 'jumlah'];
}
