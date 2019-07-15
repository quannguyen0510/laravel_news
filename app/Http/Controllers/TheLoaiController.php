<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;

class TheLoaiController extends Controller
{
    //
    public function getDanhsach() {
        $theloai = TheLoai::all();
        return view('admin.theloai.danhsach', ['theloai'=>$theloai]);
    }

    public function getThem() {
        return view('admin.theloai.them');
    }

    public function postThem(Request $request) {
        $this->validate($request,
            [
                /* cac dieu kien, unique:table:column=> kiem tra ton tai du lieu */
                'Ten'=>'required|unique:TheLoai,Ten|min:3|max:100'
            ],
            [
                /* cac thong bao loi */
                'Ten.required'=>'Ban chua dien ten the loai',
                'Ten.unique'=>'The loai da ton tai',
                'Ten.min'=>'Ten the loai phai tu 3->100 ki tu',
                'Ten.max'=>'Ten the loai phai tu 3->100 ki tu',
            ]);

        $theloai = new TheLoai;
        $theloai->Ten = $request->Ten;
        $theloai->TenKhongDau = changeTitle($request->Ten);
        $theloai->save();

        return redirect('admin/theloai/them')->with('thongbao', 'Them thanh cong');
    }

    public function getSua($id){
        $theloai = TheLoai::find($id);
        return view('admin.theloai.sua', ['theloai'=>$theloai]);
    }

    public function postSua(Request $request, $id) {
        $theloai = TheLoai::find($id);
        $this->validate($request,
            [
                /* cac dieu kien, unique:table:column=> kiem tra ton tai du lieu */
                'Ten'=>'required|unique:TheLoai,Ten|min:3|max:100'
            ],
            [
                /* cac thong bao loi */
                'Ten.required'=>'Ban chua dien ten the loai',
                'Ten.unique'=>'The loai da ton tai',
                'Ten.min'=>'Ten the loai phai tu 3->100 ki tu',
                'Ten.max'=>'Ten the loai phai tu 3->100 ki tu',
            ]);

        $theloai->Ten = $request->Ten;
        $theloai->TenKhongDau = changeTitle($request->Ten);
        $theloai->save();

        return redirect('admin/theloai/sua/'.$id)->with('thongbao', 'Sua thanh cong');
    }

    public function getXoa($id){
        $theloai = TheLoai::find($id);
        $theloai->delete();

        return redirect('admin/theloai/danhsach')->with('thongbao', 'Xoa thanh cong');
    }
}
