<?php

namespace App\Providers;

use App\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        /**
         * Set dynamic configuration for third party services
         */
        $amazonS3Config = [
            'filesystems.disks.s3' =>
                [
                    'driver' => 's3',
                    'key' => getenv('AWS_ACCESS_KEY_ID'),
                    'secret' => getenv('AWS_SECRET_ACCESS_KEY'),
                    'region' => getenv('AWS_DEFAULT_REGION'),
                    'bucket' => getenv('AWS_BUCKET'),
                ]
        ];
        $facebookConfig = [
            'services.facebook' =>
                [
                    'client_id'     => get_option('fb_app_id'),
                    'client_secret' => get_option('fb_app_secret'),
                    'redirect'      => url('login/facebook-callback'),
                ]
        ];
        $googleConfig = [
            'services.google' =>
                [
                    'client_id'     => get_option('google_client_id'),
                    'client_secret' => get_option('google_client_secret'),
                    'redirect'      => url('login/google-callback'),
                ]
        ];
        config($amazonS3Config);
        config($facebookConfig);
        config($googleConfig);

        view()->composer('*', function($view)
        {
            $header_menu_pages = Post::where('status',1)->where('show_in_header_menu', 1)->get();
            $show_in_footer_menu = Post::where('status',1)->where('show_in_footer_menu', 1)->get();
            
            $enable_monetize = get_option('enable_monetize');
            $loggedUser = null;
            if(Auth::check()) {
                $loggedUser = Auth::user();
            }
            $view->with(['lUser' => $loggedUser, 'enable_monetize'=>$enable_monetize , 'header_menu_pages' => $header_menu_pages, 'show_in_footer_menu' => $show_in_footer_menu]);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
