<?php 
/**
 * 此文件是用户页面用来编辑用户的接口
 */

//引用外部文件
include '../../../function.php';

//获取传过来的id
$id=$_GET['id'];

//调用查询函数   返回是一个数组
$data = select("select * from users where id=$id");

//判断是否查询成功
if(is_array($data)){
	$arr=array(
		"code"=>200,
		"msg"=>"查询数据成功...",
		"data"=>$data
	);
}else{
	$arr=array(
		"code"=>400,
		"msg"=>"查询数据失败..."
	);
}

echo json_encode($arr);
?>