@extends('admin.layout.index')
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Tin Tuc
                        <small>Them</small>
                    </h1>
                </div>
                <!-- /.col-lg-12 -->
                <div class="col-lg-7" style="padding-bottom:120px">
                    @if(count($errors) > 0)
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $err)
                                {{$err}}<br>
                            @endforeach
                        </div>
                    @endif

                    @if(session('thongbao'))
                        <div class="alert alert-success">
                            {{session('thongbao')}}
                        </div>
                    @endif
                    <form action="admin/tintuc/them" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="form-group">
                            <label>The Loai</label>
                            <select class="form-control" name="TheLoai" id="TheLoai">
                                @foreach($theloai as $tl)
                                    <option value="{{$tl->id}}">{{$tl->Ten}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Loai tin</label>
                            <select class="form-control" name="LoaiTin" id="LoaiTin">
                                @foreach($loaitin as $lt)
                                    <option value="{{$lt->id}}">{{$lt->Ten}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tieu de</label>
                            <input class="form-control" name="tieude" placeholder="Nhap ten loai tin"/>
                        </div>
                        <div class="form-group">
                            <label>Tom tat</label>
                            <textarea class="form-control" rows="3" name="tomtat"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Noi dung</label>
                            <textarea class="form-control ckeditor" rows="5" name="noidung" id="demo"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Hinh anh</label>
                            <input type="file" name="hinhanh" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Noi bat</label>
                            <label class="radio-inline">
                                <input name="noibat" value="1" checked="" type="radio">Noi bat
                            </label>
                            <label class="radio-inline">
                                <input name="noibat" value="0" type="radio">Khong noi bat
                            </label>
                        </div>
                        <button type="submit" class="btn btn-default">Them</button>
                        <button type="reset" class="btn btn-default">Reset</button>
                    </form>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $("#TheLoai").change(function () {
                var idTheLoai = $(this).val();
                $.get("admin/ajax/loaitin/" + idTheLoai, function (data) {
                    $('#LoaiTin').html(data);
                });
            })
        })
    </script>
    @endsection
