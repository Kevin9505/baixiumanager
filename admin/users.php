<?php 
//引用外部文件
include '../function.php';
setSession();

 ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Users &laquo; Admin</title>
  <?php include './inc/css.php'?>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include './inc/navBar.php'?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>用户</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="row">
        <div class="col-md-4">
          <form id="myform">
            <h2>添加新用户</h2>
            <div class="form-group">
              <label for="email">邮箱</label>
              <input id="email" class="form-control" name="email" type="email" placeholder="邮箱">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
              <p class="help-block">https://zce.me/author/<strong>slug</strong></p>
            </div>
            <div class="form-group">
              <label for="nickname">昵称</label>
              <input id="nickname" class="form-control" name="nickname" type="text" placeholder="昵称">
            </div>
            <div class="form-group">
              <label for="password">密码</label>
              <input id="password" class="form-control" name="password" type="text" placeholder="密码">
            </div>
            <div class="form-group">
              <!-- <button class="btn btn-primary" type="submit">添加</button> -->
              <span class="btn btn-primary btnAdd">添加</span>
            </div>
          </form>
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <span class="btn btn-danger btn-sm" id="deleteAll" style="visibility: hidden">批量删除</spana>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
               <tr>
                <th class="text-center" width="40"><input id="checkAll" type="checkbox"></th>
                <th class="text-center" width="80">头像</th>
                <th>邮箱</th>
                <th>别名</th>
                <th>昵称</th>
                <th>状态</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>
              
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  
  <?php $current_page="users" ?>
  <?php include './inc/aside.php'?>
  <?php include './inc/script.php'?>

  <script>NProgress.done()</script>
</body>
</html>
<!-- 用户列表渲染模板 -->
<script type="text/template" id="userlitsTem">
  {{each data as val key}}
    <tr>
      <td class="text-center"><input class="checkChild" value="{{val.id}}" type="checkbox"></td>
      <td class="text-center"><img class="avatar" src="{{val.avatar}}"></td>
      <td>{{val.email}}</td>
      <td>{{val.slug}}</td>
      <td>{{val.nickname}}</td>
      {{ if val.status=='unactivated' }}
        <td>未激活</td>
      {{ else if val.status=='activated' }}
        <td>激活</td>
      {{ else if val.status=='forbidden' }}
        <td>禁用</td>
      {{ else }}
        <td>废弃</td>
      {{/if}}
      <td class="text-center">
        <span class="btn btn-default btn-xs editUser" data-id="{{val.id}}">编辑</span>
        <span class="btn btn-danger btn-xs delUser" data-id="{{val.id}}">删除</span>
      </td>
    </tr>
  {{/each}}
</script>
<!-- 编辑用户模板 -->
<script type="text/template" id="usereditTem">
  <h2>编辑用户</h2>
  <input type="hidden" value={{id}} name="id">
  <div class="form-group">
    <label for="email">邮箱</label>
    <input id="email" class="form-control" name="email" type="email" placeholder="邮箱" value="{{email}}">
  </div>
  <div class="form-group">
    <label for="slug">别名</label>
    <input id="slug" class="form-control" name="slug" type="text" placeholder="slug" value="{{slug}}">
    <p class="help-block">https://zce.me/author/<strong>slug</strong></p>
  </div>
  <div class="form-group">
    <label for="nickname">昵称</label>
    <input id="nickname" class="form-control" name="nickname" type="text" placeholder="昵称" value="{{nickname}}">
  </div>
  <div class="form-group">
    <span class="btn btn-primary btnEdit">更新</span>
  </div>
</script>
<!-- 更新后调用的模板 -->
<script type="text/template" id="useraddTem">
  <h2>添加新用户</h2>
  <div class="form-group">
    <label for="email">邮箱</label>
    <input id="email" class="form-control" name="email" type="email" placeholder="邮箱">
  </div>
  <div class="form-group">
    <label for="slug">别名</label>
    <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
    <p class="help-block">https://zce.me/author/<strong>slug</strong></p>
  </div>
  <div class="form-group">
    <label for="nickname">昵称</label>
    <input id="nickname" class="form-control" name="nickname" type="text" placeholder="昵称">
  </div>
  <div class="form-group">
    <label for="password">密码</label>
    <input id="password" class="form-control" name="password" type="text" placeholder="密码">
  </div>
  <div class="form-group">
    <!-- <button class="btn btn-primary" type="submit">添加</button> -->
    <span class="btn btn-primary btnAdd">添加</span>
  </div>
</script>
<script>

render();

//用户列表渲染函数
function render(){
  //发送请求
  $.ajax({
    url:'./int/users/userInt.php',
    type:'get',
    dataType:'json',
    success:function(res){
      //判断
      if(res&&res.code==200){
        //调用模板
        var htmlStr=template('userlitsTem',res);
        //渲染页面
        $('tbody').html(htmlStr);
      }
    }
  })
}

//添加新用户
$('#myform').on('click','.btnAdd',function(){
  //发送请求
  $.ajax({
    url:'./int/users/useradd.php',
    type:'post',
    dataType:'json',
    data:$('#myform').serialize(),
    success:function(res){
      if(res&&res.code==200){
        render();   //添加数据成功后局部加载用户列表
      }
      //渲染成功后将添加部分的数据清空
      $('input[name]').val('');
    }
  })
})

//删除用户  根据自定义id 属性
$('tbody').on('click','.delUser',function(){   //由于标签是后添加的,需要用事件委派的形式注册事件
  //获取当前数据的id
  var id=$(this).attr('data-id');
  //发送请求
  $.ajax({
    url:'./int/users/userdel.php',
    type:'get',
    data:{
      id:id
    },
    dataType:'json',
    success:function(res){
      if(res&&res.code==200){
        render();   //删除成功后局部加载用户列表
      }
    }
  })
})

//编辑用户
$('tbody').on('click','.editUser',function(){
  //获取对应的id
  var id=$(this).attr('data-id');
  //发送请求
  $.ajax({
    url:'./int/users/useredit.php',
    type:'get',
    dataType:'json',
    data:{
      id:id
    },
    success:function(res){
      //判断是否有数据返回且状态码是否等于200
      if(res&&res.code==200){
        //调用编辑模板
        var htmlstr=template('usereditTem',res.data[0]);
        //渲染到页面上
        $('#myform').html(htmlstr);
      }
    }
  })
})

//更新用户信息
$('#myform').on('click','.btnEdit',function(){
  //发送请求
  $.ajax({
    url:'./int/users/userupdata.php',
    type:'post',
    data:$('#myform').serialize(),
    dataType:'json',
    success:function(res){
      console.log(res);
      //判断是否有数据信息返回且状态码为200
      if(res&&res.code==200){
        render();   //渲染更新后的数据
        //调用添加模板
        var htmlstr=template('useraddTem',{});
        $('#myform').html(htmlstr);
        // $('input[name]').val('');
      }else{
        console.log(res.msg);
      }
    }
  })
})

//全选
$('thead').on('click','#checkAll',function(){
  //获取全选按钮的状态
  var flag=$(this).prop('checked');
  //根据全选按钮的状态控制单个复选框的状态
  $('.checkChild').prop('checked',flag);
  if(flag){
    $('#deleteAll').css('visibility','visible');
  }else{
    $('#deleteAll').css('visibility','hidden');
  }
})

//单个选框
$('tbody').on('click','.checkChild',function(){
  //获取单个选框的选中个数
  var count=$('.checkChild:checked').size();
  //当被选中的个数 >=2时,批量删除按钮显示
  if(count>=2){
    $('#deleteAll').css('visibility','visible');
  }else{
    $('#deleteAll').css('visibility','hidden');
  }
  //判断单选是否全部被选中
  if(count==$('.checkChild').size()){
    $('#checkAll').prop('checked',true);
  }else{
    $('#checkAll').prop('checked',false);
  }
})

//批量删除
$('#deleteAll').on('click',function(){
  //获取对应的id
  var deleteId=[];
  $('.checkChild:checked').each(function(index,ele){
    deleteId.push($(ele).val());
  });
  // console.log(deleteId)
  //发送请求
  $.ajax({
    url:'./int/users/userdeleteAll.php',
    type:'get',
    data:{
      deleteId:deleteId.toString()
    },
    dataType:'json',
    success:function(res){
      if(res&&res.code==200){
        render();
        $('#deleteAll').css('visibility','hidden');
      }
    }
  })
})

</script>