
@extends('layouts.bst')

@section('content')
    <form action="/ceshi/login" method="post" class="form-signin">
        {{csrf_field()}}
        <h2 class="form-signin-heading">Please log in</h2>
        <label for="inputName">Name</label>
        <input type="text" name="name" id="inputNickName" class="form-control" placeholder="nickname" required autofocus>
        <label for="inputPassword" >Password</label>
        <input type="password" name="pwd" id="inputPassword" class="form-control" placeholder="***" required>
        <button class="btn-lg btn-primary btn-block" id="btn">Sign in</button>
    </form>
@endsection
@section('footer')
    @parent

    <script >
//        $('#btn').click(function(){
//            var name=$('#inputNickName').val()
//            var pwd=$('#inputPassword').val()
//            $.ajax({
//                url:"http://api.shopshan.com/login.php",
//                data:{name:name,pwd:pwd},
//                type:"get",
//                dataType:"jsonp",
//                jsonp:"callback",
//                success:function(data){
//                    alert(data.msg)
//                    if(data.code==0){
//                        location.href="/success"
//                    }
//                }
//            })
//        })
    </script>
@endsection