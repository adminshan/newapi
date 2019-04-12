<?php

namespace App\Http\Controllers\Xiu;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Umsermodel as Ummodel;

class Xiucontroller extends Controller
{
    public function Umserlist(Request $request){
            $user_id = $request->input('user_id');
            $res = Ummodel::where("user_id",$user_id)->get()->toArray();
            if(!$res){
                $data = [
                    'status'=>0
                ];
            }else{
                $arr = json_encode($res);
                $data =[
                    'status'=>1,
                    'msg'=>$arr
                ];
            }
            return $data;
    }
    //增删
    public function Umserxiu(Request $request){
        $user_id = $request->input('user_id');
        $arr = $request->input();
        
        $res = Ummodel::where("user_id",$user_id)->get()->toArray();
        if(!$res){
           $result =  Ummodel::insert($arr);
           if($result){
            $data =[
                'status'=>1,
                'msg'=>"添加成功"
            ];
           }else{
            $data =[
                'status'=>0,
                'msg'=>"添加失败"
            ];
           }
        }else{
            $result= Ummodel::where('user_id',$user_id)->update($arr);
            if($result){
                $data =[
                    'status'=>1,
                    'msg'=>"修改成功"
                ];
            }else{
                $data =[
                    'status'=>0,
                    'msg'=>"修改失败"
                ];
            }
        }
        return $data;
}
}
