<?php 
/**
 * 此文件是图片轮播页用来上传图片的接口
 */

//引用外部文件
// include '../../../function.php';

//获取上传过来图片的名称
$name = $_FILES['image']['name'];
//截取后缀
$ext = strrchr($name,'.');
//新的名称
$newName = uniqid().$ext;

//返回前台的路径
$path = "../static/uploads/$newName";

//移除临时路径
move_uploaded_file($_FILES['image']['tmp_name'],"../../$path");


//准备数据返回
$arr = array(
	'code'  => 200,
	'msg'   => '图片上传成功...',
	'src'   => $path
);

echo json_encode($arr);






