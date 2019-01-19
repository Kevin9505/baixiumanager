<?php 
//引用外部文件
include '../function.php';
setSession();

 ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Posts &laquo; Admin</title>
  <?php include './inc/css.php' ?>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include './inc/navBar.php' ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>所有文章</h1>
        <a href="post-add.php" class="btn btn-primary btn-xs">写文章</a>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
        <form class="form-inline">
          <select name="category" id="category" class="form-control input-sm">
            <option value="*">所有分类</option>
          </select>
          <select name="status" class="form-control input-sm">
            <option value="*">所有状态</option>
            <option value="published">已发布</option>
            <option value="drafted">草稿</option>
            <option value="trashed">废弃</option>
          </select>
          <span class="btn btn-default btn-sm" id="findBtn">筛选</span>
        </form>
        <ul class="pagination pagination-sm pull-right">
          
        </ul>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox"></th>
            <th>标题</th>
            <th>作者</th>
            <th>分类</th>
            <th class="text-center">发表时间</th>
            <th class="text-center">状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
          
        </tbody>
      </table>
    </div>
  </div>

  <?php $current_page="posts" ?>
  <?php include './inc/aside.php' ?>

  <?php include './inc/script.php' ?>
  <!-- 分页插件 -->
  <script src="../static/assets/vendors/twbs-pagination/jquery.twbsPagination.min.js"></script>
  <script>NProgress.done()</script>
</body>
</html>
<!-- 所有文章列表渲染模板 -->
<script type="text/template" id="postslistTem">
  {{each data as val index}}
    <tr>
      <td class="text-center"><input type="checkbox"></td>
      <td>{{val.title}}</td>
      <td>{{val.nickname}}</td>
      <td>{{val.name}}</td>
      <td class="text-center">{{val.created}}</td>
      {{if val.status == "published"}}
        <td class="text-center">已发布</td>
      {{else if val.status == "drafted"}}
        <td class="text-center">草稿</td>
      {{else if val.status == "trashed"}}
        <td class="text-center">废弃</td>
      {{/if}}
      <td class="text-center">
        <a href="./post-edit.php?id={{val.id}}" class="btn btn-default btn-xs postsEdit" data-id="{{val.id}}">编辑</a>
        <span class="btn btn-danger btn-xs postsDelete" data-id="{{val.id}}">删除</span>
      </td>
    </tr>
  {{/each}}
</script>
<!-- 所有分类模板 -->
<script type="text/template" id="categorylistTem">
  {{each category as val index}}
    <option value="{{val.id}}">{{val.name}}</option>
  {{/each}}
</script>

<script>
  //定义全局变量存储页面数
  var totalPagesCount=1;
  //定义全局变量存储当前页码
  var currentSize=1;
  //渲染所有文章列表
  render();
  function render(){
    //方式请求
    $.ajax({
      url:'./int/posts/postsRender.php',
      type:'get',
      dataType:'json',
      success:function(res){
        // console.log(res)
        if(res&&res.code==200){
          // console.log(res)
          //调用所有文章列表渲染模板
          var htmlstr=template('postslistTem',res);
          $('tbody').html(htmlstr);
          //调用所有分类模板
          var category = template('categorylistTem',res);
          $('#category').append(category);
          //调用当前页面渲染函数
          Pagination(res.totalPagesCount);
        }
      }
    })
  }

  //分页功能
  function Pagination(totalPagesCount){
    $('.pagination').twbsPagination({
      totalPages: totalPagesCount,
      visiblePages: 5,
      first:'首页',
      last:'末页',
      next:'下一页',
      prev:'上一页',
      initiateStartPageClick:false,
      onPageClick: function (event, page) {
        CurrentPageRender(page)
        //获取当前页码
        currentSize=page;
        // console.log(currentSize)
      }
    });
  }

  //封装当前页面渲染函数
  function CurrentPageRender(page){
    // console.log(page)
    //发送请求
    $.ajax({
      url:'./int/posts/postsRender.php',
      type:'get',
      dataType:'json',
      data:{
        page:page   //page对应的页码
      },
      success:function(res){
        if(res&&res.code==200){
          // console.log(res)
          //调用模板引擎
          var htmlstr=template('postslistTem',res);
          $('tbody').html(htmlstr);
        }
      }
    })
  }
  
  //删除
  $('tbody').on('click','.postsDelete',function(){
    //获取对应的id
    var id=$(this).attr('data-id');
    //发送请求
    $.ajax({
      url:'./int/posts/postsDelete.php',
      type:'get',
      dataType:'json',
      data:{
        id:id
      },
      success:function(res){
        if(res&&res.code==200){
          // render();
          CurrentPageRender(currentSize);
          // console.log(currentSize)
        }
      }
    })
  })


  //筛选
  
  


</script>
