<?php 
/**
 * 此文件是个人资料页用来更新头像的接口
 */

//引用外部文件
include '../../../function.php';

//获取传过来头像的名称
$name=$_FILES['avatar']['name'];
//截取后缀
$ext=strrchr($name,'.');
$newName=uniqid().$ext;

//返回的路径
$path="../static/uploads/$newName";

//从临时路径转到固定路径
move_uploaded_file($_FILES['avatar']['tmp_name'],"../../$path");

//获取当前数据所属的id
session_start();
$id=$_SESSION['userInfo'][0]['id'];

//定义要更新的数据
$data=array(
	"id"=>$id,
	"avatar"=>$path
);

//调用函数,更新数据
$res = update("users",$data);

//判断是否更新成功
if($res){
	$arr=array(
		'code'=>200,
		'msg'=>'头像上传成功...',
		'data'=>$path
	);
	//设置新的session
	$_SESSION['userInfo'][0]['avatar']=$path;
	
}else{
	$arr=array(
		'code'=>200,
		'msg'=>'头像上传失败...'
	);
}

//输出
echo json_encode($arr);





