<?php 
//引用外部文件
include '../function.php';
setSession();

 ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Slides &laquo; Admin</title>
  <?php include './inc/css.php' ?>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include './inc/navBar.php' ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>图片轮播</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="row">
        <div class="col-md-4">
          <form id="myform">
            <h2>添加新轮播内容</h2>
            <div class="form-group">
              <label for="image">图片</label>
              <!-- show when image chose -->
              <img class="help-block thumbnail" style="display: none">
              <input id="image" class="form-control" name="image" type="file">
            </div>
            <div class="form-group">
              <label for="text">文本</label>
              <input id="text" class="form-control" name="text" type="text" placeholder="文本">
            </div>
            <div class="form-group">
              <label for="link">链接</label>
              <input id="link" class="form-control" name="link" type="text" placeholder="链接">
            </div>
            <div class="form-group">
              <span class="btn btn-primary" id="slidesAdd">添加</span>
            </div>
          </form>
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <span class="btn btn-danger btn-sm" id="slidesDeleteAll" style="visibility: hidden">批量删除</span>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center" width="40"><input type="checkbox" id="checkAll"></th>
                <th class="text-center">图片</th>
                <th>文本</th>
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
  
  <?php $current_page="slides" ?>
  <?php include './inc/aside.php' ?>

  <?php include './inc/script.php' ?>
  <script>NProgress.done()</script>
</body>
</html>
<script type="text/template" id="slideslistTem">
  {{each data as val index}}
    <tr>
      <td class="text-center"><input type="checkbox" class="checkChild" data-index="{{index}}"></td>
      <td class="text-center"><img class="slide" src="{{val.image}}"></td>
      <td>{{val.text}}</td>
      <td>{{val.link}}</td>
      <td class="text-center">
        <span class="btn btn-danger btn-xs slidesDelete" data-index="{{index}}">删除</span>
      </td>
    </tr>
  {{/each}}
</script>
<script>
  //封装图片轮播渲染函数
  SlidesRender();
  function SlidesRender(){
    //发送请求
    $.ajax({
      type:'get',
      url:'./int/slides/slidesRender.php',
      dataType:'json',
      success:function(res){
        if(res && res.code == 200){
          //调用模板
          var htmlstr = template('slideslistTem',res);
          $('tbody').html(htmlstr);
        }
      }
    })
  }

  //上传新的轮播图
  $('#image').on('change',function(){
    //实例化FormData()
    var data = new FormData();
    data.append('image',this.files[0]);
    //发送请求
    $.ajax({
      type:'post',
      url:'./int/slides/slidesUpdateImg.php',
      data:data,
      dataType:'json',
      processData:false,
      contentType:false,
      success:function(res){
        if(res && res.code == 200){
          // console.log(res)
          //上传成功的图片显示在页面上
          $('.thumbnail').slideDown(500).attr('src',res.src);
          //将图片的路径存储到隐藏域中,方便后面存入数据库
          $('#image').parent().append('<input type="hidden" name="image" value="'+res.src+'">');
        }
      }
    })
  })

  //添加
  $('#slidesAdd').on('click',function(){
    // console.log($('#myform').serialize())
    //发送请求
    $.ajax({
      type:'post',
      url:'./int/slides/slidesAdd.php',
      data:$('#myform').serialize(),
      dataType:'json',
      success:function(res){
        if(res && res.code == 200){
          SlidesRender();
          $('input[name]').val('');
          $('.thumbnail').slideUp(500);
        }
      }
    })
  })

  //单个删除
  $('tbody').on('click','.slidesDelete',function(){
    //发送请求
    $.ajax({
      type:'get',
      url:'./int/slides/slidesDelete.php',
      data:{
        index:$(this).attr('data-index')
      },
      dataType:'json',
      success:function(res){
        if(res && res.code == 200){
          //调用渲染函数
          SlidesRender();
        }
      }
    })
  })

  //全选
  $('#checkAll').on('click',function(){
    //获取全选框的状态
    var flag = $(this).prop('checked');
    //根据全选框的状态控制单个选框的状态
    $('.checkChild').prop('checked',flag);
    //根据全选框的状态控制批量删除按钮的显示
    if(flag){
      $('#slidesDeleteAll').css('visibility','visible');
    }else{
      $('#slidesDeleteAll').css('visibility','hidden');
    }
  })

  //单个选框
  $('tbody').on('click','.checkChild',function(){
    //获取单个选框被选中的个数
    var count = $('.checkChild:checked').size();
    //当单个选框被选中的个数 >=2 时,批量删除按钮显示
    if(count >= 2){
      $('#slidesDeleteAll').css('visibility','visible');
    }else{
      $('#slidesDeleteAll').css('visibility','hidden');
    }
    //当单个选框被选中的个数等于总数时,全选被选中
    if(count == $('.checkChild').size()){
      $('#checkAll').prop('checked',true);
    }else{
      $('#checkAll').prop('checked',false);
    }
  })

  //批量删除
  $('#slidesDeleteAll').on('click',function(){
    //获取对应的索引
    var index = [];
    $('.checkChild:checked').each(function(key,ele){
      index.push($(ele).attr('data-index'));
    })
    //发送请求
    $.ajax({
      type:'get',
      url:'./int/slides/slidesDeleteAll.php',
      dataType:'json',
      data:{
        index:index
      },
      success:function(res){
        if(res && res.code == 200){
          //调用渲染函数
          SlidesRender();
          $('#slidesDeleteAll').css('visibility','hidden');
        }
      }
    })
  })


</script>
