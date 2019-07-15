@extends('layout.index')
@section('content')
    <!-- Page Content -->

    <div class="container">
        <div class="row">
            @include('layout.menu')
<?php
    function hightlight($str, $key) {
        return str_replace($key, "<span style='color:red;'>$key</span>", $str);
    }
?>
            <div class="col-md-9 ">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background-color:#337AB7; color:white;">
                        <h4><b>Kết quả tìm kiếm cho: {{$tukhoa}}</b></h4>
                    </div>
                    @foreach($tintuc as $tt)
                        <div class="row-item row">
                            <div class="col-md-3">

                                <a href="tintuc/{{$tt->id}}/{{$tt->TieuDeKhongDau}}.html">
                                    <br>
                                    <img width="200px" height="200px" class="img-responsive"
                                         src="upload/tintuc/{{$tt->Hinh}}"
                                         alt="">
                                </a>
                            </div>

                            <div class="col-md-9">
                                <h3>{!! hightlight($tt->TieuDe,$tukhoa) !!}</h3>
                                <p>{!! hightlight($tt->TomTat,$tukhoa) !!}</p>
                                <a class="btn btn-primary" href="tintuc/{{$tt->id}}/{{$tt->TieuDeKhongDau}}.html">Xem
                                    them <span
                                            class="glyphicon glyphicon-chevron-right"></span></a>
                            </div>
                            <div class="break"></div>
                        </div>
                @endforeach
                <!-- Pagination -->
                    <div style="text-align: center">
                        {{ $tintuc->appends(Request::all())->links() }}
                    </div>
                    <!-- /.row -->

                </div>
            </div>

        </div>

    </div>
    <!-- end Page Content -->
@endsection