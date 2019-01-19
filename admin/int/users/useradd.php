<?php
/**
 * 此文件是用户页面用来添加新的用户的接口
 */

//1 引用外部文件
include '../../../function.php';

//获取传过来的用户信息
$arr=$_POST;
//调用添加函数
$res = add("users",$arr);

//判断是否添加成功,添加成功后返回true或false
if($res){
	$arr=array(
		"code"=>200,
		"msg"=>"添加数据成功..."
	);
}else{
	$arr=array(
		"code"=>400,
		"msg"=>"添加数据失败,请重试..."
	);
}
//将信息返回
echo json_encode($arr);

?>
