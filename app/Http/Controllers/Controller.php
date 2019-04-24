<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    public $theme = '';

    public function __construct(){
        $selected_theme = get_option('default_theme');

        if ( ($selected_theme == 'default_theme') || $selected_theme == 'classic' ){
            $this->theme = 'theme.';
        }else{
            $this->theme = 'theme.'.$selected_theme.'.';
        }



    }
}
