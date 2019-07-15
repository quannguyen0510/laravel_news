<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\User;

class UserController extends Controller
{
    //
    public function getDanhsach()
    {
        $user = User::all();
        return view('admin.user.danhsach', ['user' => $user]);
    }

    public function getThem()
    {
        return view('admin.user.them');
    }

    public function postThem(Request $request)
    {
        $this->validate($request,
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:3|max:32',
                'rePassword' => 'required|same:password'
            ],
            [
                'name.required' => 'Ban chua nhap ten nguoi dung',
                'email.required' => 'Ban chua nhap email',
                'email.email' => 'Ban chua nhap dung dinh dang email',
                'email.unique' => 'Email da ton tai',
                'password.required' => 'Ban chua dien mat khau',
                'password.min' => 'Mat khau phai co tu 3->32 ki tu',
                'password.max' => 'Mat khau phai co tu 3->32 ki tu',
                'rePassword.required' => 'Ban chua dien lai mat khau',
                'rePassword.same' => 'Mat khau xac nhan khong dung'
            ]);

        $usr = new User;
        $usr->name = $request->name;
        $usr->email = $request->email;
        $usr->quyen = $request->role;
        $usr->password = bcrypt($request->password);
        $usr->save();

        return redirect('admin/user/them')->with('thongbao', 'Them thanh cong');
    }

    public function getSua($id)
    {
        $user = User::find($id);
        return view('admin.user.sua', ['user' => $user]);
    }

    public function postSua(Request $request, $id)
    {
        $usr = User::find($id);
        $this->validate($request,
            [
                'name' => 'required',
            ],
            [
                'name.required' => 'Ban chua nhap ten nguoi dung',
            ]);
        $usr->name = $request->name;
        $usr->email = $request->email;
        $usr->quyen = $request->role;
        if ($request->changePassword == 'on') {

            $this->validate($request,
                [
                    'password' => 'required|min:3|max:32',
                    'rePassword' => 'required|same:password'
                ],
                [
                    'password.required' => 'Ban chua dien mat khau',
                    'password.min' => 'Mat khau phai co tu 3->32 ki tu',
                    'password.max' => 'Mat khau phai co tu 3->32 ki tu',
                    'rePassword.required' => 'Ban chua dien lai mat khau',
                    'rePassword.same' => 'Mat khau xac nhan khong dung'
                ]);

            $usr->password = bcrypt($request->password);
        }
        $usr->save();

        return redirect('admin/user/sua/' . $id)->with('thongbao', 'Sua thanh cong');
    }

    public function getXoa($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect('admin/user/danhsach')->with('thongbao', 'Xoa thanh cong');
    }

    public function getDangnhapadmin()
    {
        return view('admin.login');
    }

    public function postDangnhapadmin(Request $request)
    {
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
            return redirect('admin/theloai/danhsach');
        } else {
            return redirect('admin/dangnhap')->with('thongbao', 'Sai tai khoan hoac mat khau');
        }
    }

    public function getDangXuatAdmin() {
        Auth::logout();
        return redirect('admin/dangnhap');
    }
}
