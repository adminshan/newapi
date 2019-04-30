<?php

namespace App\Http\Controllers\Login;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
class LoginController extends Controller
{
    public function login(){
        return view('login.login');
    }
    public function doLogin(Request $request)
    {
        $uid=1;
        $name = $request->input('name');
        $pwd = $request->input('pwd');
        if($name!=='admin'){
            echo 'Login failed';
        }else if ($pwd !== '111111') {
            echo 'Login failed';
        } else {
            $token = substr(md5(time() . mt_rand(1, 99999)), 10, 10);
            setcookie('uid', $uid, time() + 86400, '/', '', false, true);
            setcookie('token', $token, time() + 86400, '/', '', false, true);
            $redis_token = 'str:u:token:web:' . $uid;
            Redis::set($redis_token, $token);
            echo 'Login successful';
            header("refresh:0.2;/show/list");
        }
    }
    public function showlist(){

        $token=$_COOKIE['token'];
        //echo $token;die;
        $uid=$_COOKIE['uid'];
        $redis_token = 'str:u:token:web:' . $uid;
        $redis_token=Redis::get($redis_token);
        if($token!==$redis_token){
            echo '您在其他网站登录，若继续操作请登录';
            setcookie('uid',$_COOKIE['uid'],time()-1,'/','',false,true);
            setcookie('token',$_COOKIE['token'],time()-1,'/','',false,true);
            header("refresh:2;/admin/login");
        }else{
            echo '欢迎登录';
        }
    }
}
