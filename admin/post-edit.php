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
        <h1>编辑文章</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <form class="row" id="myform">
        
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
<!-- 调用工具文件 -->
<script src="../uitils/uitils.js"></script>
<script type="text/template" id="posteditTem">
  <input type="hidden" name="id" value="{{contentData[0].id}}">
  <input type="hidden" name="user_id" value="{{contentData[0].user_id}}">
  <div class="col-md-9">
    <div class="form-group">
      <label for="title">标题</label>
      <input id="title" class="form-control input-lg" name="title" value="{{contentData[0].title}}" type="text" placeholder="文章标题">
    </div>
    <div class="form-group">
      <label for="content">内容</label>
      <textarea id="content" style="width: 100%" input-lg" name="content" cols="30" rows="10" placeholder="内容">{{contentData[0].content}}</textarea>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label for="slug">别名</label>
      <input id="slug" class="form-control" name="slug" type="text" value="{{contentData[0].slug}}" placeholder="slug">
      <p class="help-block">https://zce.me/post/<strong>slug</strong></p>
    </div>
    <div class="form-group">
      
      <label for="feature">特色图像</label>
      <!-- show when image chose -->
      {{if contentData[0].feature == ""}}
        <img class="help-block thumbnail" style="display: none">
      {{else}}
        <img class="help-block thumbnail" src="{{contentData[0].feature}}" style="display: block">
      {{/if}}
      <input id="feature" class="form-control" type="file">
    </div>
    <div class="form-group">
      <label for="category">所属分类</label>
      <select id="category" class="form-control" name="category_id">
        {{each categorData as val index}}
          <option value="{{val.id}}" {{if val.id==contentData[0].category_id}}selected{{/if}}>{{val.name}}</option>
        {{/each}}
      </select>
    </div>
    <div class="form-group">
      <label for="created">发布时间</label>
      <input id="created" class="form-control" name="created" value="{{contentData[0].created.replace(' ','T')}}" type="datetime-local">
    </div>
    <div class="form-group">
      <label for="status">状态</label>
      <select id="status" class="form-control" name="status">
        <option value="published" {{if contentData[0].status=='published'}}selected{{/if}}>已发布</option>
        <option value="drafted" {{if contentData[0].status=='drafted'}}selected{{/if}}>草稿</option>
        <option value="trashed" {{if contentData[0].status=='trashed'}}selected{{/if}}>废弃</option>
      </select>
    </div>
    <div class="form-group">
      <span class="btn btn-primary" id="postsUpdate">更新</span>
    </div>
  </div>
</script>
<script>
  //封装页面渲染的函数
  EditRender();
  function EditRender(){
    //从地址栏中获取对应的id,调用字符串转为对象的工具
    var id = uitils.converToObj(location.search).id;
    //发送请求
    $.ajax({
      url:'./int/posts/postsEdit.php',
      type:'get',
      dataType:'json',
      data:{
        id:id
      },
      success:function(res){
        if(res&&res.code==200){
          //调用模板引擎
          var htmlstr=template('posteditTem',res);
          $('#myform').html(htmlstr);
          //调用富文本
          var ue = UE.getEditor('content');
        }
      }
    })
  }

  //更新文章
  $('#myform').on('click','#postsUpdate',function(){
    console.log($('#myform').serialize())
    //发送请求
    $.ajax({
      url:'./int/posts/postsUpdate.php',
      type:'post',
      dataType:'json',
      data:$('#myform').serialize(),
      success:function(res){
        if(res&&res.code==200){
          //一般直接写在一个js文件中
          layui.use(['layer', 'form'], function(){
            var layer = layui.layer
            ,form = layui.form;
            
            layer.msg('更新成功',{time:500},function(){
              location.href='./posts.php';
            });
          });
        }
      }
    })
  })

  //更新特色图像
  $('#myform').on('change','#feature',function(){
    //实例化 FormData() 对象
    var data = new FormData();
    data.append('feature',this.files[0]);
    //发送请求
    $.ajax({
      url:'./int/posts/postsfeatureUpdateimg.php',
      type:'post',
      dataType:'json',
      data:data,
      contentType:false,
      processData:false,
      success:function(res){
        if(res&&res.code==200){
          console.log(res);
          $('#feature').prev().attr('src',res.src);
          $('#feature').parent().append("<input type='hidden' name='feature' value='"+res.src+"'>")
        }
      }
    })
  })

  

</script>
