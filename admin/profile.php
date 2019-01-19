<?php 
//引用外部文件
include '../function.php';
setSession();

 ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Dashboard &laquo; Admin</title>
  <?php include './inc/css.php' ?>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include './inc/navBar.php' ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>我的个人资料</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <form class="form-horizontal" id="myform">
        
      </form>
    </div>
  </div>
  
  <?php $current_page="profile" ?>
  <?php include './inc/aside.php' ?>

  <?php include './inc/script.php' ?>
  <script>NProgress.done()</script>
</body>
</html>
<!-- 渲染模板 -->
<script type="text/template" id="profileTem">
  <div class="form-group">
    <label class="col-sm-3 control-label">头像</label>
    <div class="col-sm-6">
      <label class="form-image">
        <input id="avatar" type="file">
        <img src="{{avatar}}">
        <i class="mask fa fa-upload"></i>
      </label>
    </div>
  </div>
  <div class="form-group">
    <label for="email" class="col-sm-3 control-label">邮箱</label>
    <div class="col-sm-6">
      <input id="email" class="form-control" type="type" value="{{email}}" placeholder="邮箱" readonly>
      <p class="help-block">登录邮箱不允许修改</p>
    </div>
  </div>
  <div class="form-group">
    <label for="slug" class="col-sm-3 control-label">别名</label>
    <div class="col-sm-6">
      <input id="slug" class="form-control" name="slug" type="type" value="{{slug}}" placeholder="slug">
      <p class="help-block">https://zce.me/author/<strong>zce</strong></p>
    </div>
  </div>
  <div class="form-group">
    <label for="nickname" class="col-sm-3 control-label">昵称</label>
    <div class="col-sm-6">
      <input id="nickname" class="form-control" name="nickname" type="type" value="{{nickname}}" placeholder="昵称">
      <p class="help-block">限制在 2-16 个字符</p>
    </div>
  </div>
  <div class="form-group">
    <label for="bio" class="col-sm-3 control-label">简介</label>
    <div class="col-sm-6">
      <textarea id="bio" name="bio" class="form-control" placeholder="Bio" cols="30" rows="6">{{bio}}</textarea>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-3 col-sm-6">
      <span class="btn btn-primary" id="profileUpdate">更新</span>
      <a class="btn btn-link" href="password-reset.php?id={{id}}">修改密码</a>
    </div>
  </div>
</script>
<script>
  //渲染
  render();
  function render(){
    //发送请求
    $.ajax({
      url:"./int/profile/profileSelect.php",
      type:'get',
      dataType:'json',
      success:function(res){
        if(res&&res.code==200){
          // console.log(res.data[0])
          var htmlstr=template('profileTem',res.data[0]);
          $('#myform').html(htmlstr)
        }
      }
    })
  }

  //上传头像
  $('#myform').on('change','#avatar',function(){
    //获取上传的文件
    var data=new FormData();
    data.append('avatar',this.files[0]);
    //发送请求
    $.ajax({
      url:'./int/profile/profileAvatar.php',
      type:'post',
      data:data,
      contentType:false,
      dataType:'json',
      processData:false,
      success:function(res){
        if(res&&res.code==200){
          //设置头像在页面上显示
          $('#avatar').next().attr('src',res.data);
          $('.avatar').attr('src',res.data);
        }
      }
    })
  })

  //更新个人资料
  $('#myform').on('click','#profileUpdate',function(){
    //发送请求
    $.ajax({
      url:'./int/profile/profileUpdate.php',
      data:$('#myform').serialize(),
      dataType:'json',
      type:'post',
      success:function(res){
        if(res&&res.code==200){
          // render();
          //一般直接写在一个js文件中
          layui.use(['layer', 'form'], function(){
            var layer = layui.layer
            ,form = layui.form;
            
            layer.msg('保存成功',{time:1000},function(){
              location.reload();
            });
          });
          
        }
      }
    })
  })

</script>
