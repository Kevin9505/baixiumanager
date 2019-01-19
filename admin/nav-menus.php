<?php 
//引用外部文件
include '../function.php';
setSession();

 ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Navigation menus &laquo; Admin</title>
  <?php include './inc/css.php' ?>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include './inc/navBar.php' ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>导航菜单</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="row">
        <div class="col-md-4">
          <form id="myform">
            <h2>添加新导航链接</h2>
            <div class="form-group">
              <div class="form-group">
              <label for="icon">图标</label>
              <input id="icon" class="form-control" name="icon" type="icon" placeholder="图标">
            </div>
              <label for="text">文本</label>
              <input id="text" class="form-control" name="text" type="text" placeholder="文本">
            </div>
            <div class="form-group">
              <label for="title">标题</label>
              <input id="title" class="form-control" name="title" type="text" placeholder="标题">
            </div>
            <div class="form-group">
              <label for="link">链接</label>
              <input id="link" class="form-control" name="link" type="link" placeholder="链接">
            </div>
            <div class="form-group">
              <span class="btn btn-primary" id="navmenuAdd">添加</span>
            </div>
          </form>
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <span class="btn btn-danger btn-sm" id="navmenusDeleteAll" style="visibility: hidden">批量删除</span>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center" width="40"><input type="checkbox" id="checkAll"></th>
                <th>文本</th>
                <th>标题</th>
                <th>链接</th>
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
  
  <?php $current_page="nav-menus" ?>
  <?php include './inc/aside.php' ?>

  <?php include './inc/script.php' ?>
  <script>NProgress.done()</script>
</body>
</html>
<script type="text/template" id="navmenuslistTem">
  {{each data as val index}}
    <tr>
      <td class="text-center"><input type="checkbox" class="checkChild" data-index="{{index}}"></td>
      <td><i class="{{val.icon}}"></i>{{val.text}}</td>
      <td>{{val.title}}</td>
      <td>{{val.link}}</td>
      <td class="text-center">
        <span class="btn btn-danger btn-xs navmenuDel" data-index="{{index}}">删除</span>
      </td>
    </tr>
  {{/each}}
</script>
<script>
  //封装导航菜单渲染函数
  navmenusRender();
  function navmenusRender(){
    //发送请求
    $.ajax({
      url:'./int/navmenus/navmenusRender.php',
      type:'get',
      dataType:'json',
      success:function(res){
        if(res && res.code == 200){
          //调用模板
          var htmlstr = template('navmenuslistTem',res);
          $('tbody').html(htmlstr);
        }
      }
    })
  }

  //添加新的导航链接
  $('#myform').on('click','#navmenuAdd',function(){
    //发送请求
    $.ajax({
      url:'./int/navmenus/navmenusAdd.php',
      type:'post',
      dataType:'json',
      data:$('#myform').serialize(),
      success:function(res){
        if(res && res.code == 200){
          //调用渲染函数
          navmenusRender();
          //将文本框中的值清空
          $('input[name]').val('');
        }
      }
    })
  })

  //删除导航
  $('tbody').on('click','.navmenuDel',function(){
    //发送请求
    $.ajax({
      url:'./int/navmenus/navmenusDel.php',
      type:'get',
      dataType:'json',
      data:{
        index:$(this).attr('data-index')
      },
      success:function(res){
        if(res && res.code == 200){
          //调用渲染函数
          navmenusRender();
        }
      }
    })
  })

  //全选
  $('#checkAll').on('click',function(){
    //获取全选框当前的状态
    var flag = $(this).prop('checked');
    //根据全选的状态控制单个选框的状态
    $('.checkChild').prop('checked',flag);
    //根据全选状态控制批量删除按钮
    if(flag){
      $('#navmenusDeleteAll').css('visibility','visible');
    }else{
      $('#navmenusDeleteAll').css('visibility','hidden');
    }
  })

  //单个选框
  $('tbody').on('click','.checkChild',function(){
    //获取单个选框被选中的个数
    var count = $('.checkChild:checked').size();
    //当被选中的个数 >=2 时,批量删除按钮显示
    if(count >=2){
      $('#navmenusDeleteAll').css('visibility','visible');
    }else{
      $('#navmenusDeleteAll').css('visibility','hidden');
    }
    //当被选中的个数等于总个数时,全选框被选中
    if(count == $('.checkChild').size()){
      $('#checkAll').prop('checked',true);
    }else{
      $('#checkAll').prop('checked',false);
    }
  })

  //批量删除
  $('#navmenusDeleteAll').on('click',function(){
    //获取对象的索引值
    var index = [];
    $('.checkChild:checked').each(function(key,ele){
      index.push($(ele).attr('data-index'));
    })
    //发送请求
    $.ajax({
      url:'./int/navmenus/navmenusDeleteAll.php',
      type:'get',
      dataType:'json',
      data:{
        index:index
      },
      success:function(res){
        if(res && res.code == 200){
          //调用渲染函数
          navmenusRender();
          $('#navmenusDeleteAll').css('visibility','hidden');
        }
      }
    })
  })


</script>
