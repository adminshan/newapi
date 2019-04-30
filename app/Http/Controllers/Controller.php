<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Model\OpensslModel;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //加密
    public function encode($data){
        $json_str = json_encode($data);
        //echo $json_str;die;
        $post_str = base64_encode($json_str);
        //var_dump($post_str);die;
        $info=OpensslModel::first();
        $priv=$info->priv;
        $pub=$info->pub;
        $encryptData="";
        openssl_private_encrypt($post_str,$encryptData,$priv);
        $destr = base64_encode($encryptData);
        //echo $destr;echo '<br>';die;
        $this->decode($destr,$pub);
    }
    //解密
    public function decode($destr,$pub){
        $str=base64_decode($destr);
        $decrypData="";
        openssl_public_decrypt($str,$decrypData,$pub);
        $info=base64_decode($decrypData);
        $data=json_decode($info);
        var_dump($data);
    }
}
