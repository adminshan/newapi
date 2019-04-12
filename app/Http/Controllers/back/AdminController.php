<?php

namespace App\Http\Controllers\back;
use Illuminate\Http\Request;
use App\Model\AdminUser;
use App\Http\Controllers\Controller;
use App\Model\Role;
use App\Model\Power;
/**
 * Class GoodsController
 * @package App\Http\Controllers\back
 * Author Geshanshan
 * Date 2019-04-11
 */
class AdminController extends Controller{
    /**
     * @param Request $request
     * 检测登录人员
     */
    public function checkLogin(Request $request){
        $data = $request->input();
        $info=AdminUser::where('role_id',1)->first()->toArray();
        if($data['admin_name'] == $info['admin_name'] && $data['password']==$info['password'] ){
            return json_encode(['code'=>0,'msg'=>'ok']);
        }else{
            return json_encode(['code'=>1,'msg'=>'fail']);
        }

    }
    /**
     * @param Request $request
     * 管理员列表+角色
     */
    public function adminList(){
        $adminUserInfo = AdminUser::join('p_role','p_role.role_id','=','admin_user.role_id')
            ->get()
            ->toArray();
//        var_dump($adminUserInfo);die;
        return view('back.admin.adminUserList',['adminUserInfo'=>$adminUserInfo]);
    }

    /*
     * 添加子管理员 或者超级管理员
     */
    public function adminAddDo(Request $request){
        $data = $request->input();
        $adminData =[
            'admin_name'=>$data['admin_name'],
            'password'=>$data['password'],
            'admin_tel'=>$data['admin_tel'],
            'add_time'=>time(),
            'role_id'=>$data['role_id']
        ];
        $res =AdminUser::insert($adminData);
        if($res){
            return json_encode(['code'=>0,'msg'=>'ok']);
        }else{
            return json_encode(['code'=>1,'msg'=>'添加失败']);

        }
    }

    /**
     * 角色列表
     */
    public function roleList(){
        $roleInfo = Role::all()->toArray();
        return view('back.role.roleList',['roleInfo'=>$roleInfo]);
    }
    /**
     * 添加角色
     */
    public function roleAddDo(){

    }

    /**
     * 权限列表
     */
    public function powerList(){
        $powerInfo = Power::all()->toArray();
        return view('back.power.powerList',['powerInfo'=>$powerInfo]);
    }

    /**
     * 添加权限
     */

    public function powerAdd(){

    }
}