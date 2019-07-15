<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LoaiTin;
use App\TheLoai;
use App\TinTuc;
use App\Comment;

class TinTucController extends Controller
{
    //
    public function getDanhsach()
    {
        $tintuc = TinTuc::orderBy('id', 'DESC')->get();
        return view('admin.tintuc.danhsach', ['tintuc' => $tintuc]);
    }

    public function getThem()
    {
        $theloai = TheLoai::all();
        $loaitin = LoaiTin::all();
        return view('admin.tintuc.them', ['theloai' => $theloai, 'loaitin' => $loaitin]);
    }

    public function postThem(Request $request)
    {
        $this->validate($request,
            [
                /* cac dieu kien, unique:table:column=> kiem tra ton tai du lieu */
                'tieude' => 'required|unique:tintuc,TieuDe|min:3|max:100',
                'hinhanh' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'tomtat' => 'required',
                'noidung' => 'required',
                'TheLoai' => 'required',
                'LoaiTin' => 'required'
            ],
            [
                /* cac thong bao loi */
                'tieude.required' => 'Ban chua dien tieu de',
                'tieude.unique' => 'Tieu de da ton tai',
                'tieude.min' => 'Tieu de phai tu 3->100 ki tu',
                'tieude.max' => 'Tieu de phai tu 3->100 ki tu',
                'hinhanh.image' => 'File ban chon khong phai anh',
                'hinhanh.mimes' => 'Duoi anh chi duoc phep la jpeg,png,jpg,gif,svg',
                'hinhanh.max' => 'Hinh anh co kich co lon nhat la 2MB',
                'tomtat.required' => 'Ban chua dien tom tat',
                'noidung.required' => 'Ban chua dien noi dung',
                'TheLoai.required' => 'Ban chua chon the loai',
                'LoaiTin.required' => 'Ban chua chon loai tin'
            ]);

        $tintuc = new TinTuc;
        $tintuc->idLoaiTin = $request->LoaiTin;
        $tintuc->TieuDe = $request->tieude;
        $tintuc->TieuDeKhongDau = changeTitle($tintuc->tieude);
        $tintuc->TomTat = $request->tomtat;
        $tintuc->NoiDung = $request->noidung;
        $tintuc->NoiBat = $request->noibat;
        $tintuc->SoLuotXem = 0;

        if ($request->hasFile('hinhanh')) {
            $file = $request->file('hinhanh');
            $name = $file->getClientOriginalName();
            $hinhanh = str_random(4) . "_" . $name;
            while (file_exists('upload/tintuc' . $hinhanh)) {
                $hinhanh = str_random(4) . "_" . $name;
            }
            $file->move('upload/tintuc', $hinhanh);
            $tintuc->Hinh = $hinhanh;
        } else {
            $tintuc->Hinh = "";
        }

        $tintuc->save();

        return redirect('admin/tintuc/them')->with('thongbao', 'Them thanh cong');
    }

    public function getSua($id)
    {
        $tintuc = TinTuc::find($id);
        $theloai = TheLoai::all();
        $loaitin = LoaiTin::all();
        return view('admin.tintuc.sua', ['tintuc' => $tintuc, 'theloai' => $theloai, 'loaitin' => $loaitin]);
    }

    public function postSua(Request $request, $id)
    {
        $tintuc = TinTuc::find($id);
        $this->validate($request,
            [
                /* cac dieu kien, unique:table:column=> kiem tra ton tai du lieu */
                'tieude' => 'required|min:3|max:100',
                'hinhanh' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'tomtat' => 'required',
                'noidung' => 'required',
                'TheLoai' => 'required',
                'LoaiTin' => 'required'
            ],
            [
                /* cac thong bao loi */
                'tieude.required' => 'Ban chua dien tieu de',
                'tieude.min' => 'Tieu de phai tu 3->100 ki tu',
                'tieude.max' => 'Tieu de phai tu 3->100 ki tu',
                'hinhanh.image' => 'File ban chon khong phai anh',
                'hinhanh.mimes' => 'Duoi anh chi duoc phep la jpeg,png,jpg,gif,svg',
                'hinhanh.max' => 'Hinh anh co kich co lon nhat la 2MB',
                'tomtat.required' => 'Ban chua dien tom tat',
                'noidung.required' => 'Ban chua dien noi dung',
                'TheLoai.required' => 'Ban chua chon the loai',
                'LoaiTin.required' => 'Ban chua chon loai tin'
            ]);

        $tintuc->idLoaiTin = $request->LoaiTin;
        $tintuc->TieuDe = $request->tieude;
        $tintuc->TieuDeKhongDau = changeTitle($tintuc->tieude);
        $tintuc->TomTat = $request->tomtat;
        $tintuc->NoiDung = $request->noidung;
        $tintuc->NoiBat = $request->noibat;

        if ($request->hasFile('hinhanh')) {
            $file = $request->file('hinhanh');
            $name = $file->getClientOriginalName();
            $hinhanh = str_random(4) . "_" . $name;
            while (file_exists('upload/tintuc' . $hinhanh)) {
                $hinhanh = str_random(4) . "_" . $name;
            }
            unlink('upload/tintuc/' . $tintuc->Hinh);
            $file->move('upload/tintuc', $hinhanh);
            $tintuc->Hinh = $hinhanh;
        } else {

        }

        $tintuc->save();

        return redirect('admin/tintuc/sua/' . $id)->with('thongbao', 'Sua thanh cong');
    }

    public function getXoa($id)
    {
        $tintuc = TinTuc::find($id);
        $tintuc->delete();

        return redirect('admin/tintuc/danhsach')->with('thongbao', 'Xoa thanh cong');
    }
}
