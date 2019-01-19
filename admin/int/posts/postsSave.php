<?php 
/**
 * 此文件是写文章页保存文章的接口
 */

//引用外部文件
include '../../../function.php';

//在session中获取用户id
session_start();
$id=$_SESSION['userInfo'][0]['id'];

//追加到传过来的数组中
$_POST['user_id']=$id;

//调用函数
$res = add("posts",$_POST);

//判断是否添加成功
if($res){
	$arr=array(
		'code'=>200,
		'msg'=>'文章保存成功...'
	);
}else{
	$arr=array(
		'code'=>400,
		'msg'=>'文章保存失败,请重试...'
	);
}

//返回数据
echo json_encode($arr);




