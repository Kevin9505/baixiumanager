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
  <?php include './inc/css.php'?>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include './inc/navBar.php'?>
    <div class="container-fluid">
      <div class="jumbotron text-center">
        <h1>One Belt, One Road</h1>
        <p>Thoughts, stories and ideas.</p>
        <p><a class="btn btn-primary btn-lg" href="post-add.php" role="button">写文章</a></p>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">站点内容统计：</h3>
            </div>
            <ul class="list-group">
              <!-- <li class="list-group-item"><strong>10</strong>篇文章（<strong>2</strong>篇草稿）</li>
              <li class="list-group-item"><strong>6</strong>个分类</li>
              <li class="list-group-item"><strong>5</strong>条评论（<strong>1</strong>条待审核）</li> -->
            </ul>
          </div>
        </div>
        <div class="col-md-4"></div>
        <div class="col-md-4"></div>
      </div>
    </div>
  </div>
  
  <?php $current_page="index" ?>
  <?php include './inc/aside.php'?>
  <?php include './inc/script.php'?>

  <script>NProgress.done()</script>
</body>
</html>
<!-- 首页渲染模板 -->
<script type="text/template" id="indexlistTem">
  <li class="list-group-item"><strong>{{postsCount}}</strong>篇文章（<strong>{{draftedCount}}</strong>篇草稿）</li>
  <li class="list-group-item"><strong>{{categoryCount}}</strong>个分类</li>
  <li class="list-group-item"><strong>{{commentCount}}</strong>条评论（<strong>{{heldCount}}</strong>条待审核）</li>
</script>
<script>
  // 封装首页渲染函数
  InderRender();
  function InderRender(){
    //发送请求
    $.ajax({
      type:'get',
      url:'./int/index/indexRender.php',
      dataType:'json',
      success:function(res){
        if(res && res.code == 200){
          // console.log(res)
          //调用模板
          var htmlstr = template('indexlistTem',res);
          $('.list-group').html(htmlstr);
        }
      }
    })
  }
</script>
