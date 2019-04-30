<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<table>
    <tr>
        <td>Name</td>
        <td><input type="text" name="name" id="inputNickName" placeholder="nickname"></td>
    </tr>
    <tr>
        <td>Password</td>
        <td><input type="password" name="pwd" id="inputPassword" placeholder="***" ></td>
    </tr>
</table>
<button id="btn">Sign in</button>

</body>
</html>
<script src="js/jquery.min.js"></script>
<script >
    $('#btn').click(function(){
        var name=$('#inputNickName').val()
        var pwd=$('#inputPassword').val()
        $.ajax({
            url:"http://api.shopshan.com/login.php",
            data:{name:name,pwd:pwd},
            type:"get",
            dataType:"jsonp",
            jsonp:"callback",
            success:function(data){
                alert(data.msg)
                if(data.code==0){
                    location.href="/success"
                }
            }
        })
    })
</script>
