<?php 
/**
 * 此文件是网站设置页面用来上传网站图标的接口
 */

//获取上传过来的图片的名称
$name = $_FILES['logo']['name'];
//截取后缀
$ext = strrchr($name,'.');
//新的名称
$newName = uniqid().$ext;

//固定的路径
$path = "../static/uploads/$newName";
//移除临时路径
move_uploaded_file($_FILES['logo']['tmp_name'],"../../$path");

//准备数据返回
$arr = array(
	'code'  => 200,
	'msg'   => '图标上传成功...',
	'src'   => $path
);

//输出
echo json_encode($arr);




