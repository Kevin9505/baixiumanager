<?php 
/**
 * 此文件是用户页面用来删除用户的接口
 */

//1 引用外部文件
include '../../../function.php';

//获取传过来的信息
$id=$_GET['id'];

//调用删除数据函数
$res = delete("users",$id);

//判断是否成功
if($res){
	$arr=array(
		"code"=>200,
		"msg"=>"删除用户成功..."
	);
}else{
	$arr=array(
		"code"=>400,
		"msg"=>"删除用户失败..."
	);
}
//将处理信息返回
echo json_encode($arr);
?>