@extends('layout.index')
@section('content')
    <div class="container">

        @include('layout.slide')

        <div class="space20"></div>


        <div class="row main-left">
            @include('layout.menu')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background-color:#337AB7; color:white;">
                        <h2 style="margin-top:0px; margin-bottom:0px;">Liên hệ</h2>
                    </div>

                    <div class="panel-body">
                        <!-- item -->
                        Just contact.

                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>
@endsection