<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\LoaiTin;
use App\TinTuc;
use Illuminate\Support\Facades\Auth;
use App\User;

class PageController extends Controller
{
    // Bien $theloai trong cac view dung view share duoc cai dat trong app\Providers\AppServiceProvider

    public function trangchu()
    {
        return view('pages.trangchu');
    }

    public function lienhe()
    {
        return view('pages.lienhe');
    }

    public function gioithieu()
    {
        return view('pages.gioithieu');
    }

    public function loaitin($id)
    {
        $loaitin = LoaiTin::find($id);
        $tintuc = TinTuc::where('idLoaiTin', $id)->paginate(5);
        return view('pages.loaitin', ['loaitin'=>$loaitin, 'tintuc'=>$tintuc]);
    }

    public function tintuc($id)
    {
        $tintuc = TinTuc::find($id);
        $tinnoibat = TinTuc::where('NoiBat', 1)->take(4)->get();
        $tinlienquan = TinTuc::where([['idLoaiTin',$tintuc->idLoaiTin],['id','<>',$id]])->take(4)->get();
        /* tang so luot xem khi co nguoi xem tin */
        TinTuc::where('id', $id)->update(['SoLuotXem'=>$tintuc->SoLuotXem+1]);
        return view('pages.tintuc', ['tintuc'=>$tintuc, 'tinnoibat'=>$tinnoibat, 'tinlienquan'=>$tinlienquan]);
    }

    public function getDangnhap() {
        return view('pages.dangnhap');
    }

    public function postDangnhap(Request $request) {
        $this->validate($request,
            [
                'email' => 'required',
                'password' => 'required|min:3|max:32'
            ],
            [
                'email.required' => 'Ban chua nhap email',
                'password.required' => 'Ban chua dien mat khau',
                'password.min' => 'Mat khau phai co tu 3->32 ki tu',
                'password.max' => 'Mat khau phai co tu 3->32 ki tu',
            ]);
        /* Kiem tra dang nhap */
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('trangchu');
        } else {
            return redirect('dangnhap')->with('thongbao', 'Sai tai khoan hoac mat khau');
        }
    }

    public function getDangXuat() {
        Auth::logout();
        return redirect('trangchu');
    }

    public function getNguoidung() {
        return view('pages.nguoidung');
    }

    public function postNguoidung(Request $request) {

        $this->validate($request,
            [
                'name' => 'required',
            ],
            [
                'name.required' => 'Ban chua nhap ten nguoi dung',
            ]);
        Auth::user()->name = $request->name;
        if ($request->checkPassword == 'on') {

            $this->validate($request,
                [
                    'password' => 'required|min:3|max:32',
                    'passwordAgain' => 'required|same:password'
                ],
                [
                    'password.required' => 'Ban chua dien mat khau',
                    'password.min' => 'Mat khau phai co tu 3->32 ki tu',
                    'password.max' => 'Mat khau phai co tu 3->32 ki tu',
                    'passwordAgain.required' => 'Ban chua dien lai mat khau',
                    'passwordAgain.same' => 'Mat khau xac nhan khong dung'
                ]);

            Auth::user()->password = bcrypt($request->password);
        }
        Auth::user()->save();

        return redirect('nguoidung')->with('thongbao', 'Sua thanh cong');
    }

    public function getDangky() {
        return view('pages.dangky');
    }

    public function postDangky(Request $request) {

        $this->validate($request,
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:3|max:32',
                'passwordAgain' => 'required|same:password'
            ],
            [
                'name.required' => 'Ban chua nhap ten nguoi dung',
                'email.required' => 'Ban chua dien email',
                'email.email' => 'Email khong dung dinh dang',
                'email.unique' => 'Email tren da duoc su dung',
                'password.required' => 'Ban chua dien mat khau',
                'password.min' => 'Mat khau phai co tu 3->32 ki tu',
                'password.max' => 'Mat khau phai co tu 3->32 ki tu',
                'passwordAgain.required' => 'Ban chua dien lai mat khau',
                'passwordAgain.same' => 'Mat khau xac nhan khong dung'
            ]);
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->quyen = 0;
        $user->save();

        return redirect('dangky')->with('thongbao', 'Dang ky thanh cong');
    }

    public function getTimkiem(Request $request) {

        $tukhoa = $request->tukhoa;
        $tintuc = TinTuc::where('TieuDe','like',"%$tukhoa%")->orWhere('TomTat','like',"%$tukhoa%")->take(20)->paginate(5);
        return view('pages.timkiem', ['tukhoa' => $tukhoa, 'tintuc' => $tintuc]);
    }
}
