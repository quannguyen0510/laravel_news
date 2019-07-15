@extends('admin.layout.index')
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">User
                        <small>{{$user->name}}</small>
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
                    <form action="admin/user/sua/{{$user->id}}" method="POST">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="form-group">
                            <label>Ten</label>
                            <input class="form-control" name="name" value="{{$user->name}}"/>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" value="{{$user->email}}" readonly/>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" id="changePassword" name="changePassword">
                            <label>Doi mat khau</label>
                            <input type="password" class="form-control password" name="password"
                                   placeholder="Nhap mat khau" disabled=""/>
                        </div>
                        <div class="form-group">
                            <label>Xac nhan mat khau</label>
                            <input type="password" class="form-control password" name="rePassword"
                                   placeholder="Nhap lai mat khau" disabled=""/>
                        </div>
                        <div class="form-group">
                            <label>Category Status</label>
                            <label class="radio-inline">
                                <input name="role" value="1" @if($user->quyen == 1)
                                {{'checked'}}
                                @endif type="radio">Admin
                            </label>
                            <label class="radio-inline">
                                <input name="role" value="0" @if($user->quyen == 0)
                                {{'checked'}}
                                @endif type="radio">Thuong
                            </label>
                        </div>
                        <button type="submit" class="btn btn-default">Sua</button>
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
            $("#changePassword").change(function () {
                if($(this).is(":checked")) {
                    $(".password").removeAttr("disabled");
                }
                else {
                    $(".password").attr("disabled",'');
                }
            })
        });
    </script>
@endsection
