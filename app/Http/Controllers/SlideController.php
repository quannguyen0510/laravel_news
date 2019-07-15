<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slide;

class SlideController extends Controller
{
    //
    public function getDanhsach()
    {
        $slide = Slide::all();
        return view('admin.slide.danhsach', ['slide' => $slide]);
    }

    public function getThem()
    {
        return view('admin.slide.them');
    }

    public function postThem(Request $request)
    {
        $this->validate($request,
            [
                /* cac dieu kien, unique:table:column=> kiem tra ton tai du lieu */
                'ten' => 'required|unique:slide,Ten|min:3|max:100',
                'hinhanh' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'link' => 'required',
                'noidung' => 'required'
            ],
            [
                /* cac thong bao loi */
                'ten.required' => 'Ban chua dien ten slide',
                'ten.unique' => 'Ten slide da ton tai',
                'ten.min' => 'Ten slide phai tu 3->100 ki tu',
                'ten.max' => 'Ten slide phai tu 3->100 ki tu',
                'hinhanh.image' => 'File ban chon khong phai anh',
                'hinhanh.mimes' => 'Duoi anh chi duoc phep la jpeg,png,jpg,gif,svg',
                'hinhanh.max' => 'Hinh anh co kich co lon nhat la 2MB',
                'link.required' => 'Ban chua dien link',
                'noidung.required' => 'Ban chua dien noi dung',
            ]);

        $slide = new Slide;
        $slide->Ten = $request->ten;
        $slide->NoiDung = $request->noidung;
        $slide->link = $request->link;

        if ($request->hasFile('hinhanh')) {
            $file = $request->file('hinhanh');
            $name = $file->getClientOriginalName();
            $hinhanh = str_random(4) . "_" . $name;
            while (file_exists('upload/slide' . $hinhanh)) {
                $hinhanh = str_random(4) . "_" . $name;
            }
            $file->move('upload/slide', $hinhanh);
            $slide->Hinh = $hinhanh;
        } else {
            $slide->Hinh = "";
        }

        $slide->save();

        return redirect('admin/slide/them')->with('thongbao', 'Them thanh cong');
    }

    public function getSua($id)
    {
        $slide = Slide::find($id);
        return view('admin.slide.sua', ['slide' => $slide]);
    }

    public function postSua(Request $request, $id) {

        $slide = Slide::find($id);
        $this->validate($request,
            [
                /* cac dieu kien, unique:table:column=> kiem tra ton tai du lieu */
                'ten' => 'unique:slide,Ten|min:3|max:100',
                'hinhanh' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ],
            [
                /* cac thong bao loi */
                'ten.required' => 'Ban chua dien ten slide',
                'ten.unique' => 'Ten slide da ton tai',
                'ten.min' => 'Ten slide phai tu 3->100 ki tu',
                'ten.max' => 'Ten slide phai tu 3->100 ki tu',
                'hinhanh.image' => 'File ban chon khong phai anh',
                'hinhanh.mimes' => 'Duoi anh chi duoc phep la jpeg,png,jpg,gif,svg',
                'hinhanh.max' => 'Hinh anh co kich co lon nhat la 2MB',
            ]);

        $slide->Ten = $request->ten;
        $slide->NoiDung = $request->noidung;
        $slide->link = $request->link;

        if ($request->hasFile('hinhanh')) {
            $file = $request->file('hinhanh');
            $name = $file->getClientOriginalName();
            $hinhanh = str_random(4) . "_" . $name;
            while (file_exists('upload/slide' . $hinhanh)) {
                $hinhanh = str_random(4) . "_" . $name;
            }
            unlink('upload/slide/'.$slide->Hinh);
            $file->move('upload/slide', $hinhanh);
            $slide->Hinh = $hinhanh;
        } else {

        }

        $slide->save();
        return redirect('admin/slide/sua/'.$id)->with('thongbao', 'Sua thanh cong');
    }

    public function getXoa($id)
    {
        $slide = Slide::find($id);
        $slide->delete();

        return redirect('admin/slide/danhsach')->with('thongbao', 'Xoa thanh cong');
    }
}
