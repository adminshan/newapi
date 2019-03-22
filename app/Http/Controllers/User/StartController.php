<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\UserModel;
use Illuminate\Support\Facades\Redis;

class StartController extends Controller
{
    public function reg(){
        $reurl=$_GET['reurl'] ?? env('SHOP_URL');
        $data=[
            'reurl'=>$reurl
        ];
        return view('users.reg',$data);
    }
    public function doReg(Request $request){
        $name=$request->input('name');
        $reurl=urlencode($request->input('reurl') ?? env('SHOP_URL'));
        $pwd=password_hash($request->input('pwd'),PASSWORD_BCRYPT);
        $pwd2=password_verify($request->input('pwd2'),$pwd);
        $where=[
            'name'=>$name
        ];
        $info=UserModel::where($where)->get()->toArray();
        if(!empty($info)){
            die('User registered');

        }else if($pwd2===false){
            die('Confirm that the password must match the password');
        }else{
            $data=[
                'name' =>$name,
                'pwd' =>$pwd,
                'age' =>$request->input('age'),
                'email' =>$request->input('email'),
                'score'=>0
            ];
            $uid=UserModel::insertGetId($data);
            if($uid){
                echo 'Registration success';
                header('refresh:1;/userlogin?reurl='.$reurl);
            }else{
                echo 'Registration failed';
                header('refresh:0.2;/reg');
            }
        }

    }
    public function login(){
        $reurl=$_GET['reurl'] ?? env('SHOP_URL');
        $data=[
            'reurl'=>$reurl
        ];
        return view('users.login',$data);
    }
    public function doLogin(Request $request){
        $name =$request->input('name');
        $pwd=$request->input('pwd');
        $reurl=$request->input('reurl') ?? env('SHOP_URL');
        $rqurl=urldecode($reurl);
        $data=[
            'name'=>$name
        ];
        $info=UserModel::where($data)->first();
        $pwd2=password_verify($pwd,$info->pwd);
        if(empty($info)){
            echo 'Login failed';
        }else if($pwd2===false){
            echo 'Login failed';
        }else {
            $token = substr(md5(time().mt_rand(1,99999)),10,10);
            setcookie('uid',$info->uid,time()+86400,'/','shopshan.com',false,true);
            setcookie('token',$token,time()+86400,'/','shopshan.com',false,true);
            $redis_token='str:u:token:web:'.$info->uid;
            Redis::set($redis_token,$token);
            Redis::expire($redis_token,86400);
            //echo '1';
			echo 'Login successful';
			header("refresh:0.2;$rqurl");
        }
    }
    public function apiLogin(Request $request){
        $name=$request->input('name');
        $pwd=$request->input('pwd');
        $data=[
            'name'=>$name
        ];
        $info=UserModel::where($data)->first();
        $pwd2=password_verify($pwd,$info->pwd);
        if(empty($info)){
            echo '';
            $response=[
                'error'=>4003,
                'msg'=>'Login failed1'
            ];
            return json_encode($response);
        }else if($pwd2===false){
            $response=[
                'error'=>4004,
                'msg'=>'Login failed'
            ];
            return json_encode($response);
        }else {
            $token = substr(md5(time().mt_rand(1,99999)),10,10);
            $redis_token='str:u:token:'.$info->uid;
            Redis::set($redis_token,$token);
            Redis::expire($redis_token,86400);
            $response=[
                'token'=>$token,
                'uid'=>$info->uid,
                'redis_token'=>'str:u:token:'
            ];
            return json_encode($response);
        }
    }
}
