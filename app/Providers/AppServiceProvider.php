<?php

namespace App\Providers;

use App\Slide;
use App\TheLoai;
use Illuminate\Support\ServiceProvider;
// Khai bao View
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $theloai = TheLoai::all();
        $slide = Slide::all();
        // Cau truc View::share('key','value')
        View::share('theloai', $theloai);
        View::share('slide', $slide);

        if(Auth::check())
        {
            View::share(Auth::user());
        }
    }
}
