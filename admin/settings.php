<?php 
//引用外部文件
include '../function.php';
setSession();

 ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Settings &laquo; Admin</title>
  <?php include './inc/css.php' ?>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include './inc/navBar.php' ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>网站设置</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <form class="form-horizontal" id="myform">
        <div class="form-group">
          <label for="site_logo" class="col-sm-2 control-label">网站图标</label>
          <div class="col-sm-6">
            <input id="site_logo" name="site_logo" type="hidden">
            <label class="form-image">
              <input id="logo" type="file">
              <img src="../../static/assets/img/logo.png">
              <i class="mask fa fa-upload"></i>
            </label>
          </div>
        </div>
        <div class="form-group">
          <label for="site_name" class="col-sm-2 control-label">站点名称</label>
          <div class="col-sm-6">
            <input id="site_name" name="site_name" class="form-control" type="type" placeholder="站点名称">
          </div>
        </div>
        <div class="form-group">
          <label for="site_description" class="col-sm-2 control-label">站点描述</label>
          <div class="col-sm-6">
            <textarea id="site_description" name="site_description" class="form-control" placeholder="站点描述" cols="30" rows="6"></textarea>
          </div>
        </div>
        <div class="form-group">
          <label for="site_keywords" class="col-sm-2 control-label">站点关键词</label>
          <div class="col-sm-6">
            <input id="site_keywords" name="site_keywords" class="form-control" type="type" placeholder="站点关键词">
          </div>
        </div>
        <div class="form-group">
          <label for="site_footer" class="col-sm-2 control-label">站点页脚</label>
          <div class="col-sm-6">
            <input id="site_footer" name="site_footer" class="form-control" type="type" placeholder="站点页脚">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">评论</label>
          <div class="col-sm-6">
            <div class="checkbox">
              <label><input id="comment_status" name="comment_status" type="checkbox" checked>开启评论功能</label>
            </div>
            <div class="checkbox">
              <label><input id="comment_reviewed" name="comment_reviewed" type="checkbox" checked>评论必须经人工批准</label>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-6">
            <span class="btn btn-primary" id="settingSave">保存设置</span>
          </div>
        </div>
      </form>
    </div>
  </div>

  <?php $current_page="settings" ?>
  <?php include './inc/aside.php' ?>

  <?php include './inc/script.php' ?>
  <script>NProgress.done()</script>
</body>
</html>
<script>
  //封装网站设置渲染函数
  SettingsRender()
  function SettingsRender(){
    //发送请求
    $.ajax({
      type:'get',
      url:'./int/settings/settingsRender.php',
      dataType:'json',
      success:function(res){
        console.log(res)
        if(res && res.code == 200){
          //网站图标隐藏域
          $('#site_logo').attr('value',res.data[1]['value']);
          //网站图标
          $('#logo').next().attr('src',res.data[1]['value']);
          //站点名称
          $('#site_name').attr('value',res.data[2]['value']);
          //站点描述
          $('#site_description').text(res.data[3]['value']);
          //站点关键词
          $('#site_keywords').attr('value',res.data[4]['value']);
          //站点页脚
          $('#site_footer').attr('value',res.data[5]['value']);
          //是否开启评论功能
          if(res.data[6]['value'] == '1'){
            $('#comment_status').prop('checked',true);
          }else{
            $('#comment_status').prop('checked',false);
          }
          //是否评论必须经人工批准
          if(res.data[7]['value'] == '1'){
            $('#comment_reviewed').prop('checked',true);
          }else{
            $('#comment_reviewed').prop('checked',false);
          }
        }
      }
    })
  }

  //上传网站图标
  $('#logo').on('change',function(){
    //实例化FormData()对象
    var data = new FormData();
    data.append('logo',this.files[0]);
    //发送请求
    $.ajax({
      type:'post',
      url:'./int/settings/settingLogo.php',
      data:data,
      dataType:'json',
      contentType:false,
      processData:false,
      success:function(res){
        // console.log(res)
        if(res && res.code == 200){
          //将上传成功的图片在页面上显示
          $('#logo').next().attr('src',res.src);
          $('#site_logo').attr('value',res.src);
        }
      }
    })
  })

  //保存设置
  $('#settingSave').on('click',function(){
    $.ajax({
      type:'post',
      url:'./int/settings/settingsSave.php',
      data:$('#myform').serialize(),
      dataType:'json',
      success:function(res){
        if(res && res.code == 200){
          //调用渲染函数
          SettingsRender();
        }
      }
    })
  })


</script>
