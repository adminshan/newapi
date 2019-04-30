<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;
class OldMiddleware
{
    /**
     * 运行请求过滤器
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $request_uri = $_SERVER['REQUEST_URI'];
        $uri_hash = substr(md5($request_uri),0,10);
        $ip = $_SERVER['SERVER_ADDR'];
        $key = 'api:'.$uri_hash .':'.$ip;
        $num=Redis::incr($key);  //次数+1
        Redis::expire($key,1); //时间
        if($num>5){
            $response=[
                'error'=>400,
                'msg' =>'fall'
            ];
            $user_key = 'user:ip';
            Redis::sAdd($user_key,$ip);
            echo json_encode($response);
        }

        return $next($request);
    }

}