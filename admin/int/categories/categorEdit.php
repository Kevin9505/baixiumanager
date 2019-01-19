<?php
/**
 * 此文件是用来分类页编辑分类的接口
 */

//引用外部文件
include '../../../function.php';

//获取传过来的数据
$id=$_GET['id'];

//调用函数
$data = select("select * from categories where id = '$id'");

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






