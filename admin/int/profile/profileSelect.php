<?php
/**
 * 此文件是个人资料页用来渲染的接口
 */

//引用外部文件
include '../../../function.php';
//获取邮箱
session_start();
$id=$_SESSION['userInfo'][0]['id'];

//调用函数
$data = select("select * from users where id=$id");

//判断是否查询成功
if(!empty($data)){
	$arr=array(
		'code'=>200,
		'msg'=>'数据查询成功...',
		'data'=>$data
	);
}else{
	$arr=array(
		'code'=>400,
		'msg'=>'数据查询失败...'
	);
}

echo json_encode($arr);




