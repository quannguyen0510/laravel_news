@extends('admin.layout.index')
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">User
                        <small>Them</small>
                    </h1>
                </div>
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
            <!-- /.col-lg-12 -->
                <div class="col-lg-7" style="padding-bottom:120px">
                    <form action="admin/user/them" method="POST">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="form-group">
                            <label>Ten</label>
                            <input class="form-control" name="name" placeholder="Nhap ten nguoi dung"/>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Nhap email nguoi dung"/>
                        </div>
                        <div class="form-group">
                            <label>Mat khau</label>
                            <input type="password" class="form-control" name="password" placeholder="Nhap mat khau"/>
                        </div>
                        <div class="form-group">
                            <label>Xac nhan mat khau</label>
                            <input type="password" class="form-control" name="rePassword"
                                   placeholder="Nhap lai mat khau"/>
                        </div>
                        <div class="form-group">
                            <label>Category Status</label>
                            <label class="radio-inline">
                                <input name="role" value="1" checked="" type="radio">Admin
                            </label>
                            <label class="radio-inline">
                                <input name="role" value="0" type="radio">Thuong
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
