<?php 
/**
 * 此文件是用户页面用来更新用户的接口
 */

//引用外部文件
include '../../../function.php';

//获取传过来的数据
$arr=$_POST;

//调用数据更新函数	返回true或false
$res = update("users",$arr);

//判断数据是否更新成功
if($res){
	$arr=array(
		"code"=>200,
		"msg"=>"数据更新成功..."
	);
}else{
	$arr=array(
		"code"=>400,
		"msg"=>"数据更新失败..."
	);
}

//将信息转为字符串返回
echo json_encode($arr);

?>