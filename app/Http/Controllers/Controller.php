<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function _construct() {
        $this->DangNhap();
    }

    function DangNhap() {
        /* Kiem tra neu dang dang nhap */
        if(Auth::check())
        {
            /* Truyen 1 view share cho tat ca cac view de lay thong tin nguoi dung, Auth::user() lay thong tin nguoi dung dang nhap*/
            view()->share(Auth::user());
        }
    }
}
