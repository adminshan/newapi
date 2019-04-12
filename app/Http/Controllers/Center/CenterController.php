<?php

namespace App\Http\Controllers\Center;
use App\Model\UserModel;
use App\Model\CollectModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CenterController extends Controller
{
    //修改密码
    public function changepwd(Request $request)
    {
        $pwd = $request->input('pwd');
        //echo $pwd;
        $new_pwd = $request->input('new_pwd');
       // echo $new_pwd;
        $uid = $request->input('user_id');
        $token = $request->input('token');
       // $response = $this->checkToken($token, $uid);
        $response='true';
        if ($response == 'true') {
            $where = [
                'user_id' => $uid
            ];
            $res = UserModel::where($where)->first();
            if (empty($res)) {
                $arr = [
                    'code' => 400,
                    'msg' => '用户不存在'
                ];
                echo json_encode($arr);
                die;
            }
            if ($res->user_pwd !== md5($pwd)) {
                $arr = [
                    'code' => 404,
                    'msg' => '原密码错误'
                ];
                echo json_encode($arr);
                die;
            }
            $up_data = [
                'user_pwd' => md5($new_pwd)
            ];
            $res1 = UserModel::where($where)->update($up_data);
            if ($res1) {
                $arr = [
                    'code' => 0,
                    'msg' => '修改成功'
                ];
                echo json_encode($arr);
            } else {
                $arr = [
                    'code' => 500,
                    'msg' => '修改失败'
                ];
                echo json_encode($arr);
            }
        } else {
            echo $response;
        }
    }
    //删除收藏
    public function delcollection(Request $request){
        $collect_id=$request->input('collect_id');
        $where=[
            'collect_id'=>$collect_id
        ];
        $info=CollectModel::where($where)->first();
        if(empty($info)){
            $resopnse=[
                'code'=>4003,
                'msg'=>'无此商品'
            ];
            echo json_encode($resopnse);die;
        }else{
            $res=CollectModel::where($where)->delete();
            if($res){
                $resopnse=[
                    'code'=>0,
                    'msg'=>'success',
                ];
                echo json_encode($resopnse);
            }
        }
    }
}
