<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LoaiTin;
use App\TheLoai;

class LoaiTinController extends Controller
{
    //
    public function getDanhsach() {
        $loaitin = LoaiTin::all();
        return view('admin.loaitin.danhsach', ['loaitin'=>$loaitin]);
    }

    public function getThem() {
        $theloai = TheLoai::all();
        return view('admin.loaitin.them', ['theloai'=>$theloai]);
    }

    public function postThem(Request $request) {
        $this->validate($request,
            [
                /* cac dieu kien, unique:table:column=> kiem tra ton tai du lieu */
                'Ten'=>'required|unique:loaitin,Ten|min:3|max:100',
                'TheLoai'=>'required'
            ],
            [
                /* cac thong bao loi */
                'Ten.required'=>'Ban chua dien ten the loai',
                'Ten.unique'=>'Loai tin da ton tai',
                'Ten.min'=>'Ten loai tin phai tu 3->100 ki tu',
                'Ten.max'=>'Ten loai tin phai tu 3->100 ki tu',
                'TheLoai.required'=>'Ban chua chon the loai tin'
            ]);

        $loaitin = new LoaiTin;
        $loaitin->idTheLoai = $request->TheLoai;
        $loaitin->Ten = $request->Ten;
        $loaitin->TenKhongDau = changeTitle($request->Ten);
        $loaitin->save();

        return redirect('admin/loaitin/them')->with('thongbao', 'Them thanh cong');
    }

    public function getSua($id){
        $loaitin = LoaiTin::find($id);
        $theloai = TheLoai::all();
        return view('admin.loaitin.sua', ['loaitin'=>$loaitin, 'theloai'=>$theloai]);
    }

    public function postSua(Request $request, $id) {
        $loaitin = LoaiTin::find($id);
        $this->validate($request,
            [
                /* cac dieu kien, unique:table:column=> kiem tra ton tai du lieu */
                'Ten'=>'required|unique:loaitin,Ten|min:3|max:100',
                'TheLoai'=>'required'
            ],
            [
                /* cac thong bao loi */
                'Ten.required'=>'Ban chua dien ten the loai',
                'Ten.unique'=>'Loai tin da ton tai',
                'Ten.min'=>'Ten loai tin phai tu 3->100 ki tu',
                'Ten.max'=>'Ten loai tin phai tu 3->100 ki tu',
                'TheLoai.required'=>'Ban chua chon the loai tin'
            ]);

        $loaitin->Ten = $request->Ten;
        $loaitin->TenKhongDau = changeTitle($request->Ten);
        $loaitin->idTheLoai = $request->TheLoai;
        $loaitin->save();

        return redirect('admin/loaitin/sua/'.$id)->with('thongbao', 'Sua thanh cong');
    }

    public function getXoa($id){
        $loaitin = LoaiTin::find($id);
        $loaitin->delete();

        return redirect('admin/loaitin/danhsach')->with('thongbao', 'Xoa thanh cong');
    }
}
