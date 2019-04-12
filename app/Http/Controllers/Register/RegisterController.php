<?php
namespace App\Http\Controllers\Register;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\extend\send\send;
/**
 * Class RegisterController
 * @package App\Http\Controllers\User
 * 注册
 * liuyong
 */
class RegisterController extends Controller
{
    //发送验证码
    public function sendcode(Request $request){
        $tel=$request->input("user_name");
        $num = rand(1000,9999);
        $obj=new send();
        $bol=$obj->show($tel,$num);
        dump($bol);
        if ($bol==100){
            $arr=array(
                'tel'=>$tel,
                'code'=>$num,
                'timeout'=>time()+240,
                'status'=>1
            );
            $bol=DB::table('code')->insert($arr);
            $arr=array(
                'status'=>1,
                'msg'=>'验证码发送成功'
            );
            return $arr;
        }else{
            $arr=array(
                'status'=>0,
                'msg'=>'验证码发送失败'
            );
            return $arr;
        }

    }
    //信息入库
    public function userAdd(Request $request){
        $arrr=$request->input('data');
        $tel=$arrr['user_name'];
        $pwd=$arrr['user_pwd'];
        $conpwd=$arrr['user_pwd2'];
        $code=$arrr['code'];
        //非空
        if(!$tel){
            $arr=array(
                'status'=>0,
                "msg"=>"手机号不能为空"
            );
            return $arr;
        }
        if (!$pwd){
            $arr=array(
                'status'=>0,
                "msg"=>"密码不能为空"
            );
            return $arr;
        }
        //检验密码
        if ($pwd != $conpwd){
            $arr=array(
                'status'=>0,
                "msg"=>"密码不一致",
            );
            return $arr;
        }
        //用户名唯一
        $arr=DB::table('users')->select("*")->where("user_tel",$tel)->first();
        if (!empty($arr)){
            $arr=array(
                'status'=>0,
                "msg"=>"手机号码已存在"
            );
            return $arr;
        }
        //验证码
        $time=time();
        $arrinfo=DB::table('code')->select("*")->where("code",$code)->where("timeout",$time)->where("tel",$tel)->where("status",1)->first();
        if (empty($arrinfo->id)){
            $arr=array(
                'status'=>0,
                'msg'=>"验证码错误"
            );
        }
        $pwd=md5($pwd);
        $arrinfo=array(
            'user_tel'=>$tel,
            'user_pwd'=>$pwd
        );
        //入库
        $bol=DB::table("users")->insert($arrinfo);
        if ($bol){
            $arr=array(
                'status'=>1,
                "msg"=>"注册成功"
            );
            return $arr;
        }else{
            $arr=array(
                'status'=>0,
                "msg"=>"注册失败"
            );
            return $arr;
        }

    }
}