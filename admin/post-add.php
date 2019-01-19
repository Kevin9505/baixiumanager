<?php 
//引用外部文件
include '../function.php';
setSession();

 ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Add new post &laquo; Admin</title>
  <?php include './inc/css.php' ?>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include './inc/navBar.php' ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>写文章</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <form class="row" id="myform">
        <div class="col-md-9">
          <div class="form-group">
            <label for="title">标题</label>
            <input id="title" class="form-control input-lg" name="title" type="text" placeholder="文章标题">
          </div>
          <div class="form-group">
            <label for="content">内容</label>
            <textarea id="content"  name="content" cols="30" style="width: 100%" rows="10" placeholder="内容"></textarea>
            <!-- <div id="content" class="form-control input-lg"></div> -->
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="slug">别名</label>
            <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
            <p class="help-block">https://zce.me/post/<strong>slug</strong></p>
          </div>
          <div class="form-group">
            <label for="feature">特色图像</label>
            <!-- show when image chose -->
            <img class="help-block thumbnail" style="display: none">
            <input id="feature" class="form-control" type="file">
          </div>
          <div class="form-group">
            <label for="category">所属分类</label>
            <select id="category" class="form-control" name="category_id">
              
            </select>
          </div>
          <div class="form-group">
            <label for="created">发布时间</label>
            <input id="created" class="form-control" name="created" type="datetime-local">
          </div>
          <div class="form-group">
            <label for="status">状态</label>
            <select id="status" class="form-control" name="status">
              <option value="drafted">草稿</option>
              <option value="published">已发布</option>
            </select>
          </div>
          <div class="form-group">
            <span class="btn btn-primary" id="postsSave">保存</span>
          </div>
        </div>
      </form>
    </div>
  </div>
  
  <?php $current_page="post-add" ?>
  <?php include './inc/aside.php' ?>

  <?php include './inc/script.php' ?>
  <script src="../static/assets/vendors/ueditor/ueditor.config.js"></script>
  <script src="../static/assets/vendors/ueditor/ueditor.all.js"></script>

  <script>NProgress.done()</script>
</body>
</html>
<!-- 分类渲染模板 -->
<script type="text/template" id="postsctgTem">
  {{each data as val index}}
    <option value="{{val.id}}">{{val.name}}</option>
  {{/each}}
</script>
<script>
  render();
  //所属分类渲染
  function render(){
    //发生请求
    $.ajax({
      url:'./int/posts/postsctgSelect.php',
      type:'get',
      dataType:'json',
      success:function(res){
        if(res&&res.code==200){
          //调用模板引擎
          var htmlstr=template('postsctgTem',res);
          $('#category').html(htmlstr);
          //调用富文本
          var ue = UE.getEditor('content');
        }
      }
    })
  }

  //上传特色图像
  $('#feature').on('change',function(){
    //实例化FormData()对象,追加图片
    var data=new FormData();
    data.append('feature',this.files[0]);
    //发送请求
    $.ajax({
      url:'int/posts/postsfeatureImg.php',
      type:'post',
      dataType:'json',
      data:data,
      contentType:false,
      processData:false,
      success:function(res){
        if(res&&res.code==200){
          //将图片渲染到页面上
          $('#feature').prev().show(400).attr('src',res.src);
          //将图片的路径存储到隐藏域中
          $('#feature').parent().append("<input type='hidden' name='feature' value='"+res.src+"'>");
        }
      }
    })
  })

  //保存文章
  $('#postsSave').on('click',function(){
    //发送请求
    $.ajax({
      url:'./int/posts/postsSave.php',
      data:$('#myform').serialize(),
      type:'post',
      dataType:'json',
      success:function(res){
        if(res&&res.code==200){
          //一般直接写在一个js文件中
          layui.use(['layer', 'form'], function(){
            var layer = layui.layer
            ,form = layui.form;
            //
            layer.msg('更新成功',{time:500},function(){
              location.href="./posts.php";
            });
          });
          
        }
      }
    })
  })


</script>
