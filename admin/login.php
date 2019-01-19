<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Sign in &laquo; Admin</title>
  <link rel="stylesheet" href="../../static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../../static/assets/css/admin.css">
  <!-- 弹层组件样式 -->
  <link rel="stylesheet" type="text/css" href="../static/assets/vendors/layui/css/modules/code.css">
</head>
<body>
  <div class="login">
    <form class="login-wrap">
      <img class="avatar" src="../../static/assets/img/default.png">
      <!-- 有错误信息时展示 -->
      <div class="alert alert-danger" id="loginAlert" style="visibility: hidden">
        <strong>错误！</strong> 用户名或密码错误！
      </div>
      <div class="form-group">
        <label for="email" class="sr-only">邮箱</label>
        <input id="email" type="email" class="form-control" placeholder="邮箱" autofocus>
      </div>
      <div class="form-group">
        <label for="password" class="sr-only">密码</label>
        <input id="password" type="password" class="form-control" placeholder="密码">
      </div>
      <span class="btn btn-primary btn-block" id="loginIn">登 录</span>
    </form>
  </div>
</body>
</html>
<script src="../static/assets/vendors/jquery/jquery.min.js"></script>
<script src="../static/assets/vendors/layui/layui.js"></script>
<script>
  //获取图片
  $('#email').on('blur',function(){
    var email=$('#email').val();
    $.ajax({
      url:'./int/login/getImg.php',
      type:'get',
      data:{
        email:email
      },
      // dataType:'json',
      beforeSend:function(){
        if($.trim(email)==''){
          // $('#loginAlert').css('visibility','visible').html("<strong>"+"账号或密码不能为空!"+"</strong>");
          return false;
        }
      },
      success:function(res){
        if(res){
          $('.avatar').attr('src',res);
        }else{
          $('.avatar').attr('src',"/static/assets/img/default.png");
        }
      }
    })
  })
  
  //登录
  $('#loginIn').on('click',function(){
    //获取邮箱和密码
    var email=$('#email').val();
    var password=$('#password').val();
    //发送请求
    $.ajax({
      url:'./int/login/loginIn.php',
      type:'post',
      data:{
        email:email,
        password:password
      },
      dataType:'json',
      beforeSend:function(){
        if($.trim(email)==''||$.trim(password)==''){
          $('#loginAlert').css('visibility','visible').html("<strong>"+"账号或密码不能为空!"+"</strong>");
          return false;
        }
      },
      success:function(res){
        if(res&&res.code==200){
          // console.log(res)
          // $('#loginAlert').css('visibility','visible').html("<strong>"+res.msg+"</strong>");
          // layer.msg('hello');
          
          //一般直接写在一个js文件中
          layui.use(['layer', 'form'], function(){
            var layer = layui.layer
            ,form = layui.form;
            
            layer.msg('登录成功',{time:500},function(){
              location.href="./index.php";
            });
          });

          

        }else if(res&&res.code==400){
          $('#loginAlert').css('visibility','visible').html("<strong>"+res.msg+"</strong>");
        }
      }
    })
  })
</script>
