<?php

namespace App\Traits;

use ClassFactory as CF;
use Auth;


trait ViewRender {

    public function render($page) {
        // $this->loadGlobalData();
        
        return static::$view_path.'::Views.'.$page;
    }

    public function loadGlobalData(){
      
        if(isset(request()->route()->action['guard'])){
           
            $guard = request()->route()->action['guard'];
        
            if($guard == 'admin'){
                $this->globalAdminData();
                $this->globalSignUpRequests();
            }
            if($guard == 'podiatrist'){
                $this->globalPodiatristData();
            }

        }

    }

    public function globalAdminData(){

        if(Auth::check()){

            $user =  Auth::user();
            $count = CF::model('Podiatrist')::with('Clinics')->where('status','Pending')->count();
            
            // if($user->profile_image != null and $user->profile_image != ""){
                $image = "";
            // }else{
            //     $image = '';
            // }
            
            \View::share('logged_user', $user);
            \View::share('signUpRequest', $count);
            \View::share('profile_image', $image);

        }
    }

    public function globalPodiatristData(){
     
        if(Auth::check()){
            
            $user =  Auth::user();
            // if($user->profile_image != null and $user->profile_image != ""){
                $image = "https://cdn.iconscout.com/public/images/icon/free/png-512/avatar-user-business-man-399587fe24739d5a-512x512.png";
            // }else{
            //     $image = '';
            // }
            
            \View::share('logged_user', $user);
            \View::share('profile_image', $image);

        }
    }

    public function globalSignUpRequests(){
        $count['num'] = 3;
        \View::share('signUpRequests', $count);
    }

}