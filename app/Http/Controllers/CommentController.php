<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use Illuminate\Support\Facades\Auth;
use App\TinTuc;

class CommentController extends Controller
{
    //
    public function getXoa($id, $idTintuc)
    {
        $comment = Comment::find($id);
        $comment->delete();

        return redirect('admin/tintuc/sua/'.$idTintuc)->with('thongbao', 'Xoa thanh cong');
    }
    public function postComment($id, Request $request)
    {
        $tintuc = TinTuc::find($id);
        $idTinTuc = $id;
        $comment = new Comment;
        $comment->idTintuc = $idTinTuc;
        $comment->idUser = Auth::id();
        $comment->NoiDung = $request->NoiDung;
        $comment->save();

        return redirect('tintuc/'.$id.'/'.$tintuc->TieuDeKhongDau.'.html')->with('thongbao', 'Binh luan thanh cong');
    }
}
