<?php

namespace App\Http\Controllers\Login;

use App\Model\UserModel;
use Illuminate\Http\Request;;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class LoginController extends Controller
{
    //app登录
    public function login(Request $request){
        $account = $request->input('name');
        //echo $account;die;
        $pwd = $request->input('pwd');
        $e=strpos($account,'@');
        if(!empty($e)){
            $where=[
                'email'=>$account
            ];
        }else if(empty($e)&&strlen($account==11)){
            $where=[
                'tel'=>$account
            ];
        }
        $data = UserModel::where($where)->first();
        //var_dump($where);die;
        if(empty($data) || $data->user_pwd!==md5($pwd)){
            $resopnse=[
                'code'=>50001,
                'msg'=>'账号或密码错误1！'
            ];
            echo json_encode($resopnse);die;
        }
        //验证通过，生成token
        $token = $this->getAccessToken($data->user_id);
        $user_id = $data->user_id;
        $resopnse=[
            'code'=>0,
            'msg'=>'success',
            'token'=>$token,
            'user_id'=>$user_id
        ];
        echo json_encode($resopnse);
    }
    //获取token
    public function getAccessToken($id){
        $str=time().$id.mt_rand(11111111111,99999999999);
        $str=md5($str);
        $token=substr($str,1,18);
        $redis_token="redis_token_str:".$id;
        Redis::hset($redis_token,'utoken',$token);
        return $token;
    }
    //退出
    public function quit(Request $request){
        $id=$request->input('user_id');
        $redis_token="redis_token_str:".$id;
        Redis::hdel($redis_token,'utoken');
        $arr=[
            'code'=>0,
            'msg'=>'success'
        ];
        echo json_encode($arr);
    }
    public function qqq(){
        echo md5('111111');
    }
}