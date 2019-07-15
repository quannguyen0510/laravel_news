@extends('admin.layout.index')
@section('content')

    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Slide
                        <small>{{$slide->Ten}}</small>
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
                    <form action="admin/slide/sua/{{$slide->id}}" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="form-group">
                            <label>Ten</label>
                            <input class="form-control" name="ten" value="{{$slide->Ten}}"/>
                        </div>
                        <div class="form-group">
                            <label>Noi dung</label>
                            <textarea class="form-control ckeditor" rows="5" name="noidung"
                                      id="demo">{{$slide->NoiDung}}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Hinh anh</label>
                            <p>
                                <img src="upload/slide/{{$slide->Hinh}}" width="300px">
                            </p>
                            <input type="file" name="hinhanh" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Link</label>
                            <input class="form-control" name="link" value="{{$slide->link}}"/>
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