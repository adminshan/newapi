<?php

namespace App\Http\Controllers\Openssl;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\OpensslModel;

class OpensslController extends Controller
{
    //加密
    public function encode(){
        $str='这是';
        $info=OpensslModel::first();
        $priv=$info->priv;
        $pub=$info->pub;
        $encryptData="";
        openssl_private_encrypt($str,$encryptData,$priv);
        $destr = base64_encode($encryptData);
        echo $destr;echo '<br>';
        $this->decode($destr,$pub);

    }
    //解密
    public function decode($destr,$pub){
        $str=base64_decode($destr);
        $decrypData="";
        openssl_public_decrypt($str,$decrypData,$pub);
        echo $decrypData;
    }
}
