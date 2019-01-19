<?php 
//引用外部文件
include '../function.php';
setSession();

 ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Comments &laquo; Admin</title>
  <?php include './inc/css.php' ?>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include './inc/navBar.php' ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>所有评论</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <div class="btn-batch" id="controlBtn" style="display: none">
          <button class="btn btn-info btn-sm">批量批准</button>
          <button class="btn btn-warning btn-sm">批量拒绝</button>
          <button class="btn btn-danger btn-sm" id="commentsDeleteAll">批量删除</button>
        </div>
        <ul class="pagination pagination-sm pull-right">
          
        </ul>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input id="checkAll" type="checkbox"></th>
            <th>作者</th>
            <th>评论</th>
            <th>评论在</th>
            <th>提交于</th>
            <th>状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
          
        </tbody>
      </table>
    </div>
  </div>
  
  <?php $current_page = "comments" ?>
  <?php include './inc/aside.php' ?>

  <?php include './inc/script.php' ?>
  <script src = "../static/assets/vendors/twbs-pagination/jquery.twbsPagination.min.js"></script>
  <script>NProgress.done()</script>
</body>
</html>
<!-- 评论列表渲染模板 -->
<script type = "text/template" id = "commentslistTem">
  {{each data as val index}}
    <tr>
      <td class="text-center"><input class="checkChild" type="checkbox" value="{{val.id}}"></td>
      <td>{{val.author}}</td>
      <td>{{val.content.length > 30?val.content.substring(0,30)+"...":val.content}}</td>
      <td>{{val.title}}</td>
      <td>{{val.created}}</td>
      {{if val.status == "held"}}
        <td>正在审核 <input type="hidden" name="status" class="status" value="{{val.status}}"></td>
      {{else if val.status == "approved"}}
        <td>已批准 <input type="hidden" name="status" class="status" value="{{val.status}}"></td>
      {{else if val.status == "rejected"}}
        <td>未批准 <input type="hidden" name="status" class="status" value="{{val.status}}"></td>
      {{else if val.status == "trashed"}}
        <td>废弃 <input type="hidden" name="status" class="status" value="{{val.status}}"></td>
      {{/if}}
      <td class="text-center">
        <span class="btn btn-warning btn-xs rejectBtn" 
          {{if val.status == "rejected"}}
            style="background-color: #4169E1;border: 1px solid #4169E1"
          {{else if val.status == "held"}}
            style="background-color: #FF4040;border: 1px solid #FF4040"  
          {{/if}} data-id="{{val.id}}">

          {{if val.status == "held"}}
            批准
          {{else if val.status == "rejected"}}
            审核
          {{else if val.status == "approved" || val.status == "trashed"}}
            驳回
          {{/if}}
        </span>
        <span class="btn btn-danger btn-xs commentsDelete" data-id="{{val.id}}">删除</span>
      </td>
    </tr>
  {{/each}}
</script>
<script>
  //定义全局变量
  var totalPagesCount = 1;  //总页码
  var currentPage = 1;    //当前页码数

  CommentRender();
  //封装评论数据渲染函数
  function CommentRender(){
    $.ajax({
      url:'./int/comments/commentsRender.php',
      type:'get',
      dataType:'json',
      success:function(res){
        if(res&&res.code == 200){
          // console.log(res)
          //调用渲染模板
          var htmlstr = template('commentslistTem',res);
          $('tbody').html(htmlstr);
          //调用分页函数,将传过来的总页码数做为参数
          Pagination(res.count);
        }
      }
    })
  }

  //封装分页效果函数  参数 > totalPages -->总页码数
  function Pagination(totalPagesCount){
    $('.pagination').twbsPagination({
      totalPages: totalPagesCount,   //总页数
      visiblePages: 6,   //页面显示的页码个数
      first:'首页',
      last:'末页',
      next:'下一页',
      prev:'上一页',
      initiateStartPageClick:false,
      onPageClick: function (event, page) {   //点击页码触发的函数
        // $('#page-content').text('Page ' + page);
        //调用渲染当前页码数据的函数
        CurrentPage(page);
        //获取当前页码值
        currentPage = page;
      }
    });
  }

  //封装渲染当前页码数据的函数
  function CurrentPage(page){
    //发送请求
    $.ajax({
      url:'./int/comments/commentsRender.php',
      type:'get',
      data:{
        page:page
      },
      dataType:'json',
      success:function(res){
        // console.log(res)
        if(res && res.code == 200){
          //调用渲染模板
          var htmlstr = template('commentslistTem',res);
          $('tbody').html(htmlstr);
        }
      }
    })
  }

  //单个删除
  $('tbody').on('click','.commentsDelete',function(){
    //获取对应的id
    var id = $(this).attr('data-id');
    //发送请求
    $.ajax({
      url:'./int/comments/commentsDelete.php',
      type:'get',
      dataType:'json',
      data:{
        id:id
      },
      success:function(res){
        if(res&&res.code==200){
          //一般直接写在一个js文件中
          layui.use(['layer', 'form'], function(){
            var layer = layui.layer
            ,form = layui.form;
            
            layer.msg('删除成功',{time:1000},function(){
              CurrentPage(currentPage);
            });
          });
          
        }
      }
    })
  })

  //单个驳回
  $('tbody').on('click','.rejectBtn',function(){
    //获取对应的id
    var rejectId = $(this).attr('data-id');
    // var status = $('.status').val();
    // console.log(status);
    // return;
    // var that = $(this);
    // console.log(rejectId)
    //发送请求
    $.ajax({
      type:'get',
      url:'./int/comments/commentReject.php',
      data:{
        id:rejectId
      },
      dataType:'json',
      success:function(res){
        if(res && res.code == 200){
          //一般直接写在一个js文件中
          layui.use(['layer', 'form'], function(){
            var layer = layui.layer
            ,form = layui.form;
            
            layer.msg('驳回成功',{time:1000},function(){
              CurrentPage(currentPage);
            });
          });
          
        }
      }
    })
  })
  
  //全选
  $('#checkAll').on('click',function(){
    //获取全选框当前的状态
    var flag = $(this).prop('checked');
    //根据全选框的状态控制单个选框的选中状态
    $('.checkChild').prop('checked',flag);
    if(flag){
      $('#controlBtn').css('display','inline-block');
    }else{
      $('#controlBtn').css('display','none');
    }
  })

  //单个选框
  $('tbody').on('click','.checkChild',function(){
    //获取单个选框的个数
    var count = $('.checkChild:checked').size();
    //当单个选框个数 >=2时,批量按钮显示
    if(count >= 2){
      $('#controlBtn').css('display','inline-block');
    }else{
      $('#controlBtn').css('display','none');
    }
    //当单选框个数等于单选框总数时,全选框选中
    if(count == $('.checkChild').size()){
      $('#checkAll').prop('checked',true);
    }else{
      $('#checkAll').prop('checked',false);
    }
  })

  //批量删除
  $('#commentsDeleteAll').on('click',function(){
    //获取对应的id
    var id = [];
    $('.checkChild:checked').each(function(index,ele){
      id.push($(ele).val());
    })
    //发送请求
    $.ajax({
      url:'./int/comments/commentsdeleteAll.php',
      type:'get',
      data:{
        id:id.toString()
      },
      dataType:'json',
      success:function(res){
        if(res&&res.code==200){
          //调用渲染当前页面的函数
          CurrentPage(currentPage);
          //删除成功后操作按钮隐藏
          $('#controlBtn').css('display','none');
        }
      }
    })
  })

  //批量批准






</script>