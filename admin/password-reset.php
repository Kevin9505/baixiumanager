<?php 
//引用外部文件
include '../function.php';
setSession();

 ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Password reset &laquo; Admin</title>
  <?php include './inc/css.php' ?>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include './inc/navBar.php' ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>修改密码</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <div class="alert alert-danger" id="passwordAlert" style="visibility: hidden">
        
      </div>
      <form class="form-horizontal" id="myform">
        <div class="form-group">
          <label for="old" class="col-sm-3 control-label">旧密码</label>
          <div class="col-sm-7">
            <input id="old" class="form-control" type="password" placeholder="旧密码">
          </div>
        </div>
        <div class="form-group">
          <label for="password" class="col-sm-3 control-label">新密码</label>
          <div class="col-sm-7">
            <input id="password" name="password" class="form-control" type="password" placeholder="新密码">
          </div>
        </div>
        <div class="form-group">
          <label for="confirm" class="col-sm-3 control-label">确认新密码</label>
          <div class="col-sm-7">
            <input id="confirm" class="form-control" type="password" placeholder="确认新密码">
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-3 col-sm-7">
            <span class="btn btn-primary" id="passwordUpdate">修改密码</span>
          </div>
        </div>
      </form>
    </div>
  </div>
  
  <?php $current_page="password-reset" ?>
  <?php include './inc/aside.php' ?>
  <?php include './inc/script.php' ?>
  <script src="../uitils/uitils.js"></script>
  <script>NProgress.done()</script>
</body>
</html>
<!-- <script type="text/template" id="passwordTem">
  
</script> -->
<script>
  //封装渲染旧密码的函数
  PasswordRender();
  function PasswordRender(){
    //获取地址栏的id
    var id=uitils.converToObj(location.search).id;
    //发送请求
    $.ajax({
      url:'./int/profile/passwordRender.php',
      type:'post',
      data:{
        id:id
      },
      dataType:'json',
      success:function(res){
        if(res&&res.code==200){
          console.log(res.data[0].password)
          $('#old').attr('value',res.data[0].password);
          $('#myform').append("<input type='hidden' name='id' value='"+id+"'>");
        }
      }
    })
  }

  //修改密码
  $('#passwordUpdate').on('click',function(){
    //获取新密码
    var password=$('#password').val();
    var confirm=$('#confirm').val();
    //发起请求
    $.ajax({
      url:'./int/profile/passwordUpdate.php',
      type:'post',
      data:$('#myform').serialize(),
      dataType:'json',
      beforeSend:function(){
        if($.trim(password)==''||$.trim(confirm)==''){
          return false;
        }
        if(password!=confirm){
          $('#passwordAlert').css('visibility','visible').html("<strong>错误！</strong>"+"两个密码不一致,请重新输入...");
          return false;
        }
      },
      success:function(res){
        if(res&&res.code==200){
          location.href="./login.php";
        }
      }
    })
  })

</script>
