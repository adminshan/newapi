<?php
namespace App\Http\Controllers\Img;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ImgController extends Controller
{
    public function show(){
        return view("img.img");
    }
    public function upload(){
        //print_r($_FILES);
        $tmpName=$_FILES['file']['tmp_name'];
        $content=file_get_contents($tmpName);
        //重命名
        $filename='./bbb.png';
        file_put_contents($filename,$content,FILE_APPEND);
        echo json_encode(['code'=>0,'msg'=>'ok']);
    }
}


























