<?php
/**
 * 此文件是个人资料页用来更新个人资料的接口
 */

//引用外部文件
include '../../../function.php';

session_start();
$id=$_SESSION['userInfo'][0]['id'];

$_POST['id']=$id;

//调用函数
$res = update("users",$_POST);

//判断是否更新成功
if($res){
	$arr=array(
		'code'=>200,
		'msg'=>'数据更新成功...'
	);
	//重新设置session
	$_SESSION['userInfo'][0]['nickname']=$_POST['nickname'];
}else{
	$arr=array(
		'code'=>200,
		'msg'=>'数据更新失败...'
	);
}


//输出
echo json_encode($arr);



