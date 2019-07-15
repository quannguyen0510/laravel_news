<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TheLoai extends Model
{
    //
    protected $table = "theloai";

    // Tao lien ket voi bang LoaiTin
    public function loaitin(){
        return $this->hasMany('App\LoaiTin', 'idTheLoai', 'id');
    }

    // Tao lien ket voi bang TinTuc
    public function tintuc(){
        return $this->hasManyThrough('App\TinTuc','App\LoaiTin','idTheLoai', 'idLoaiTin', 'id');
    }
}
