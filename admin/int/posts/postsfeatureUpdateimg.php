<?php 
/**
 * 此文件是用来编辑文章页面更新特色图片的接口
 */

//获取传过来的图片的名称
$name=$_FILES['feature']['name'];
//截取图片的后缀
$ext=strrchr($name,'.');
//新的图片名称
$newName=uniqid().$ext;
//新的固定路径
$path="../static/uploads/$newName";

//从临时路径移到固定路径
move_uploaded_file($_FILES['feature']['tmp_name'],"../../$path");

//准备返回的数据
$arr=array(
	'code'=>200,
	'msg'=>'图片上传成功...',
	'src'=>$path
);

//返回数据
echo json_encode($arr);












