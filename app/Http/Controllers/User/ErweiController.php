<?php
namespace App\Http\Controllers\User;

use App\Model\UserModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class ErweiController extends Controller
{
    public function generate(){
        $key="token_app";
        $useToken = Redis::scard($key);
        for($i=0;$i<100-$useToken;$i++){
            $num = rand(100,100000).time();
            $token=md5($num);
            $start=rand(0,10);
            $end=rand(11,32);
            $token=substr($token,$start,$end);
            Redis::sadd($key,$token);
        }
    }
    public function qrcode($uid){
        $key="token_app";
        $code=Redis::spop($key,$uid);
        //echo $code;die;
        $data=[
            'uid'=>$uid,
            'code'=>$code
        ];
        return view('send.qrcode',$data);
    }
    public function success(Request $request){
        $uid=$request->input('uid');
        $where=[
            'user_id'=>$uid
        ];
        $info=UserModel::where($where)->first();
        if($info){
            return 1;
//            $data=[
//                'code'=>1
//            ];
//            echo json_encode($data);
        }
    }
    public function successly(){
        echo '登陆成功';
    }

    /**
     * 生成二维码
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function code(){
        $redis=new \Redis();
        $redis->connect('127.0.0.1',6379);
        $key="token_app";
        $arr=$redis->sPop($key);
        var_dump($arr);die;
        return view('send.qrcode',['arr'=>$arr]);
    }

    /**
     * 扫描二维码
     * @param Request $request
     * @return false|string
     */
    public function codeDo(Request $request){
        $result=$request->input('result');
        $user_id=$request->input('user_id');

        $redis=new \Redis();
        $redis->connect('127.0.0.1',6379);
        $time=60;
        $res=$redis->set($result,$user_id,$time);
        if($res){
            return json_encode(['code'=>1,'msg'=>'扫描成功']);
        }else{
            return json_encode(['code'=>2,'msg'=>'扫描失败']);
        }
    }

    /**
     * 登录
     * @param Request $request
     * @return false|string
     */
    public function getCode(Request $request){
        $arr=$request->input();
        $token=$arr['token'];
        $redis=new \Redis();
        $redis->connect('127.0.0.1',6379);
        $res=$redis->get($token);
        if($res){
            return 1;
        }
    }


}