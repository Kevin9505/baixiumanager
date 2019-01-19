<?php 
//引用外部文件
include '../function.php';
setSession();

 ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Categories &laquo; Admin</title>
  <?php include './inc/css.php' ?>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include './inc/navBar.php' ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>分类目录</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="row">
        <div class="col-md-4">
          <form id="myform">
            <h2>添加新分类目录</h2>
            <div class="form-group">
              <label for="name">名称</label>
              <input id="name" class="form-control" name="name" type="text" placeholder="分类名称">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
              <p class="help-block">https://zce.me/category/<strong>slug</strong></p>
            </div>
            <div class="form-group">
              <span class="btn btn-primary" id="ctgAdd">添加</span>
            </div>
          </form>
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <span class="btn btn-danger btn-sm" id="deleteAll" style="visibility: hidden">批量删除</span>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center" width="40"><input id="checkAll" type="checkbox"></th>
                <th>名称</th>
                <th>Slug</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>
              <!-- <tr>
                <td class="text-center"><input type="checkbox"></td>
                <td>未分类</td>
                <td>uncategorized</td>
                <td class="text-center">
                  <a href="javascript:;" class="btn btn-info btn-xs">编辑</a>
                  <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                </td>
              </tr>
              <tr>
                <td class="text-center"><input type="checkbox"></td>
                <td>未分类</td>
                <td>uncategorized</td>
                <td class="text-center">
                  <a href="javascript:;" class="btn btn-info btn-xs">编辑</a>
                  <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                </td>
              </tr>
              <tr>
                <td class="text-center"><input type="checkbox"></td>
                <td>未分类</td>
                <td>uncategorized</td>
                <td class="text-center">
                  <a href="javascript:;" class="btn btn-info btn-xs">编辑</a>
                  <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                </td>
              </tr> -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  
  <?php $current_page="categories" ?>
  <?php include './inc/aside.php' ?>

  <?php include './inc/script.php' ?>
  <script>NProgress.done()</script>
</body>
</html>
<!-- 渲染分类目录的模板 -->
<script type="text/template" id="ctglistTem">
  {{each data as val index}}
    <tr>
      <td class="text-center"><input class="checkChild" type="checkbox" value={{val.id}}></td>
      <td>{{val.name}}</td>
      <td>{{val.slug}}</td>
      <td class="text-center">
        <span class="btn btn-info btn-xs ctgEdit" data-id="{{val.id}}">编辑</span>
        <span class="btn btn-danger btn-xs ctgDelete" data-id="{{val.id}}">删除</span>
      </td>
    </tr>
  {{/each}}
</script>
<!-- 编辑模板 -->
<script type="text/template" id="ctgeditTem">
  <input type="hidden" name="id" value="{{id}}">
  <h2>编辑分类目录</h2>
  <div class="form-group">
    <label for="name">名称</label>
    <input id="name" class="form-control" name="name" value="{{name}}" type="text" placeholder="分类名称">
  </div>
  <div class="form-group">
    <label for="slug">别名</label>
    <input id="slug" class="form-control" name="slug" value="{{slug}}" type="text" placeholder="slug">
    <p class="help-block">https://zce.me/category/<strong>slug</strong></p>
  </div>
  <div class="form-group">
    <span class="btn btn-primary" id="ctgUpdate">更新</span>
  </div>
</script>
<!-- 更新完成后调用的模板 -->
<script type="text/template" id="ctgaddTem">
  <h2>添加新分类目录</h2>
  <div class="form-group">
    <label for="name">名称</label>
    <input id="name" class="form-control" name="name" type="text" placeholder="分类名称">
  </div>
  <div class="form-group">
    <label for="slug">别名</label>
    <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
    <p class="help-block">https://zce.me/category/<strong>slug</strong></p>
  </div>
  <div class="form-group">
    <span class="btn btn-primary" id="ctgAdd">添加</span>
  </div>
</script>
<script>
  //渲染
  render();
  function render(){
    $.ajax({
      url:'./int/categories/categorSelete.php',
      type:'get',
      dataType:'json',
      success:function(res){
        if(res&&res.code==200){
          // console.log(res)
          var htmlstr=template('ctglistTem',res);
          $('tbody').html(htmlstr);
        }
      } 
    })
  }

  //添加数据
  $('#myform').on('click','#ctgAdd',function(){
    //发送请求
    $.ajax({
      url:'./int/categories/categorAdd.php',
      type:'post',
      dataType:'json',
      data:$('#myform').serialize(),
      beforeSend:function(){
        if($.trim($('#name').val())==''||$.trim($('#slug').val())==''){
          return false;
        }
      },
      success:function(res){
        if(res&&res.code==200){
          render();
          $('input[name]').val('');
        }
      }
    })
  })

  //删除
  $('tbody').on('click','.ctgDelete',function(){
    //获取对应的id
    var id=$(this).attr('data-id');
    //发送请求
    $.ajax({
      url:'./int/categories/categorDelete.php',
      type:'get',
      data:{
        id:id
      },
      dataType:'json',
      success:function(res){  
        if(res&&res.code==200){
          render();
        }
      }
    })
  })

  //编辑
  $('tbody').on('click','.ctgEdit',function(){
    //获取对应的id
    var id = $(this).attr('data-id');
    //发送请求
    $.ajax({
      url:'./int/categories/categorEdit.php',
      type:'get',
      data:{
        id:id
      },
      dataType:'json',
      success:function(res){
        if(res&&res.code==200){
          // console.log(res)
          var htmlstr=template('ctgeditTem',res.data[0]);
          $('#myform').html(htmlstr);
        }
      }
    })
  })

  //更新
  $('#myform').on('click','#ctgUpdate',function(){
    $.ajax({
      url:'./int/categories/categorUpdate.php',
      type:'post',
      dataType:'json',
      data:$('#myform').serialize(),
      success:function(res){
        if(res&&res.code==200){
          console.log(res)
          render();
          var htmlstr=template('ctgaddTem',{});
          $('#myform').html(htmlstr);
        }
      }
    })
  })

  //全选
  $('#checkAll').on('click',function(){
    //获取全选框的状态
    var flag=$(this).prop('checked');
    //根据全选状态控制单个选框
    $('.checkChild').prop('checked',flag);
    //根据全选状态控制批量删除按钮
    if(flag){
      $('#deleteAll').css('visibility','visible');
    }else{
      $('#deleteAll').css('visibility','hidden');
    }
  })

  //单个选框
  $('tbody').on('click','.checkChild',function(){
    //获取单个选框被选中的个数
    var count=$('.checkChild:checked').size();
    //当被选中的个数 >=2时,批量删除按钮显示
    if(count>=2){
      $('#deleteAll').css('visibility','visible');
    }else{
      $('#deleteAll').css('visibility','hidden');
    }
    //当单个选框全部被选中时,全选也被选中
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
    console.log(deleteId)
    //发送请求
    $.ajax({
      url:'./int/categories/categordeleteAll.php',
      type:'get',
      dataType:'json',
      data:{
        deleteId:deleteId.toString()
      },
      success:function(res){
        if(res&&res.code==200){
          render();
          $('#deleteAll').css('visibility','hidden');
        }
      }
    })
  })

</script>
