<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\UserModel;
use Illuminate\Support\Facades\Redis;

class CeshiController extends Controller
{
    public function reg(){
        return view('users.regs');
    }
    public function doreg(Request $request){
        $name=$request->input('name');
        $pwd=password_hash($request->input('pwd'),PASSWORD_BCRYPT);
        $pwd2=password_verify($request->input('pwd2'),$pwd);
        $where=[
            'uname'=>$name
        ];
        $info=UserModel::where($where)->get()->toArray();
        if(!empty($info)){
            die('User registered');

        }else if($pwd2===false){
            die('Confirm that the password must match the password');
        }else{
            $data=[
                'uname' =>$name,
                'pwd' =>$pwd,
                'age' =>$request->input('age'),
                'add_time'=>time(),
            ];
            $uid=UserModel::insertGetId($data);
            if($uid){
                echo 'Registration success';
                header('refresh:1;/ceshi/login');
            }else{
                echo 'Registration failed';
                header('refresh:0.2;/reg');
            }
        }
    }
    public function login(){
        return view('users.logins');
    }
    public function doLogin(Request $request)
    {
        $name = $request->input('name');
        $pwd = $request->input('pwd');
        $data = [
            'uname' => $name
        ];
        $info = UserModel::where($data)->first();
        $pwd2 = password_verify($pwd, $info->pwd);
        if (empty($info)) {
            echo 'Login failed';
        } else if ($pwd2 === false) {
            echo 'Login failed';
        } else {
            $token = substr(md5(time() . mt_rand(1, 99999)), 10, 10);
            setcookie('uid', $info->uid, time() + 86400, '/', 'shopshan.com', false, true);
            setcookie('token', $token, time() + 86400, '/', 'shopshan.com', false, true);
            $redis_token = 'str:u:token:web:' . $info->uid;
            Redis::set($redis_token, $token);
            Redis::expire($redis_token, 86400);
            echo 'Login successful';
            $userWhere=[
                'status'=>2,
                'login_time'=>time()
            ];
            UserModel::where($data)->update($userWhere);
            $user=UserModel::where($data)->first();
            if(time()-$user->login_time<1000){
                header("refresh:0.2;http://wang.shopshan.com/user/ceshi");
            }else{
                setcookie('uid',$_COOKIE['uid'],time()-1,'/','shopshan.com',false,true);
                setcookie('token',$_COOKIE['token'],time()-1,'/','shopshan.com',false,true);
                echo '已下线，请登录';
                header("refresh:0.2;http://wang.shopshan.com/user/ceshi");
            }
        }
    }
    public function user_reg(Request $request){
        $name=$request->input('name');
        $pwd=password_hash($request->input('pwd'),PASSWORD_BCRYPT);
        $pwd2=password_verify($request->input('pwd2'),$pwd);
        $where=[
            'uname'=>$name
        ];
        $info=UserModel::where($where)->get()->toArray();
        if(!empty($info)){
            die('User registered');

        }else if($pwd2===false){
            die('Confirm that the password must match the password');
        }else{
            $data=[
                'uname' =>$name,
                'pwd' =>$pwd,
                'age' =>$request->input('age'),
                'add_time'=>time(),
            ];
            $uid=UserModel::insertGetId($data);
            if($uid){
                echo 'Registration success';
                header('refresh:1;/ceshi/login');
            }else{
                echo 'Registration failed';
                header('refresh:0.2;/reg');
            }
        }
    }
    public function user_login(Request $request){
        $name = $request->input('name');
        $pwd = $request->input('pwd');
        $data = [
            'uname' => $name
        ];
        $info = UserModel::where($data)->first();
        $pwd2 = password_verify($pwd, $info->pwd);
        if (empty($info)) {
            echo 'Login failed';
        } else if ($pwd2 === false) {
            echo 'Login failed';
        } else {
            $token = substr(md5(time() . mt_rand(1, 99999)), 10, 10);
            setcookie('uid', $info->uid, time() + 86400, '/', 'shopshan.com', false, true);
            setcookie('token', $token, time() + 86400, '/', 'shopshan.com', false, true);
            $redis_token = 'str:u:token:web:' . $info->uid;
            Redis::set($redis_token, $token);
            Redis::expire($redis_token, 86400);
            echo 'Login successful';
            $userWhere=[
                'status'=>2,
                'login_time'=>time()
            ];
            UserModel::where($data)->update($userWhere);
            header("refresh:0.2;http://wang.shopshan.com/user/ceshi");
        }
    }
}
