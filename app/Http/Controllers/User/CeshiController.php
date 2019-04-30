<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\UserModel;
use App\Model\GoodsModel;
use App\Model\BanbenModel;

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
        if($info->status==2){
            echo "用户已在其他平台登录";die;
        }
        $pwd2 = password_verify($pwd, $info->pwd);
        if (empty($info)) {
            echo 'Login failed';
        } else if ($pwd2 === false) {
            echo 'Login failed';
        } else {
            $token = substr(md5(time() . mt_rand(1, 99999)), 10, 10);
            setcookie('uid', $info->uid, time() + 86400, '/', '', false, true);
            setcookie('token', $token, time() + 86400, '/', '', false, true);
            $redis_token = 'str:u:token:web:' . $info->uid;
            Redis::set($redis_token, $token);
            Redis::expire($redis_token, 86400);
            echo 'Login successful';
            $userWhere=[
                'status'=>2,
                'login_time'=>time()
            ];
            UserModel::where($data)->update($userWhere);
            header("refresh:0.2;/goodslist");
        }
    }
    public function showgoods(){
        $info=GoodsModel::all()->toArray();
        $key='str:goods';
        $datainfo=json_encode($info);
        Redis::set($key,$datainfo);
        //$Info= Redis::get($key);
        //print_r($Info);die;
        $data=$this->encode($info);
        $datalist=[
            'list'=>$info
        ];
        return view('users.list',$datalist);
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
            $response=[
                'code'=>4003,
                'msg'=>'用户已注册'
            ];
            echo json_encode($response);
        }else if($pwd2===false){
            $response=[
                'code'=>4003,
                'msg'=>'注册失败'
            ];
            echo json_encode($response);
        }else{
            $data=[
                'uname' =>$name,
                'pwd' =>$pwd,
                'age' =>$request->input('age'),
                'add_time'=>time(),
            ];
            $uid=UserModel::insertGetId($data);
            if($uid){
                $response=[
                    'code'=>1,
                    'msg'=>'注册成功'
                ];
                echo json_encode($response);
            }else{
                $response=[
                    'code'=>4003,
                    'msg'=>'注册失败'
                ];
                echo json_encode($response);
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
        if($info->status==2){
            $response=[
                'code'=>4013,
                'msg'=>'用户已在其他平台登录'
            ];
            echo json_encode($response);die;
        }
        $pwd2 = password_verify($pwd, $info->pwd);
        if (empty($info)) {
            $response=[
                'code'=>4003,
                'msg'=>'登录失败'
            ];
            echo json_encode($response);
        } else if ($pwd2 === false) {
            $response=[
                'code'=>4003,
                'msg'=>'登录失败'
            ];
            echo json_encode($response);
        } else {
            $token = substr(md5(time() . mt_rand(1, 99999)), 10, 10);
            $redis_token = 'str:u:token:web:' . $info->uid;
            Redis::set($redis_token, $token);

            Redis::expire($redis_token, 86400);
            $userWhere=[
                'status'=>2,
                'login_time'=>time()
            ];
            UserModel::where($data)->update($userWhere);
            $response=[
                'code'=>0,
                'msg'=>'登陆成功',
                'uid'=>$info->uid,
                'token'=>$token
            ];
            echo json_encode($response);
        }

    }
    public function showlist(){
        $data=GoodsModel::all()->toArray();
        $info=[
            'data'=>$data
        ];
        if(!empty($info)){
            echo json_encode($info);
        }
    }























    public function success(){
        echo  "欢迎登录";
    }
    public function banben(Request $request){
        $banben=$request->input('banben');
        $info=BanbenModel::max('banben');
       if($banben<$info){
           $response=[
               'code'=>300,
               'msg'=>'请升级',
           ];
       }
        echo json_encode($response);
    }
}
