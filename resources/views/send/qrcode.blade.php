{{--@extends('layouts.bst')--}}

{{--@section('content')--}}
    {{--{{csrf_field()}}--}}
    {{--<input type="hidden" value="{{$arr}}" id="code">--}}
    {{--<div id="qrcode" align="center"></div>--}}
    {{--<h2 align="center">登录</h2>--}}
{{--@endsection--}}
{{--@section('footer')--}}
    {{--@parent--}}
    {{--<script src="{{URL::asset('/js/qrcode.js')}}"></script>--}}
    {{--<script>--}}
{{--//        var code=$('#code').val()--}}
        {{--// 设置参数方式--}}
        {{--var qrcode = new QRCode('qrcode', {--}}
            {{--text: '{{$arr}}',--}}
            {{--width: 256,--}}
            {{--height: 256,--}}
            {{--colorDark : '#000000',--}}
            {{--colorLight : '#ffffff',--}}
            {{--correctLevel : QRCode.CorrectLevel.H--}}
        {{--});--}}
{{--//        qrcode.clear();--}}
{{--//        qrcode.makeCode('new content');--}}
{{--            //var token="{{$arr}}";--}}
            {{--setInterval(function(){--}}
                {{--$.post('getCode',{token:token},function(data){--}}
                    {{--if(data==1){--}}
                        {{--alert('登录成功');--}}
                        {{--window.location.href="/successly";--}}
                    {{--}--}}
                {{--})--}}
            {{--},5000)--}}


    {{--</script>--}}
{{--@endsection--}}




        <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .paywrapp{
            margin-left: 520px;
        }
    </style>
    <link href="css/comm.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/cartlist.css">
    <link rel="stylesheet" href="layui/css/layui.css">
</head>
<body>

<div class="paywrapp">
    <form action="" method="post" name="payPassword" id="form_paypsw">
        <div id="payPassword_container" class="alieditContainer clearfix" data-busy="0">
            <div class="i-block" data-error="i_error">
                <div id="qrcode" class="qrcode">
                </div>
            </div>
        </div>
    </form>
    <div class="submit">
        <a href="payment" class="button  cancel">取消</a>
        <a href="index"  class="button">返回</a>
    </div>
</div>
</body>
</html>
<script src="js/jquery.min.js"></script>
<script src="js/qrcode.js"></script>
<script>
    // 设置参数方式
    var qrcode = new QRCode('qrcode', {
        text: '{{$arr}}',
        width: 256,
        height: 256,
        colorDark : '#000000',
        colorLight : '#ffffff',
        correctLevel : QRCode.CorrectLevel.H
    });
//    qrcode.clear();
//    qrcode.makeCode();
    setInterval(function(){
        var token="{{$arr}}";
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url     :   '/getCode',
            type    :   'post',
            data    :   {token:token},
            dataType:   'json',
            success :   function(res){
                if(res==1){
                    location.href= '/successly';
                }
            }
        });
    },5000)


</script>