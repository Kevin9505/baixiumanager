<?php
/**
 * 此文件是用户页面用来删除所有用户的接口
 */

//引用外部文件
include '../../../function.php';
//调用删除数据的函数
$res = delete("users",$_GET['deleteId']);

if($res){
	$arr=array(
		'code'=>200,
		'msg'=>'数据删除成功...'
	);
}else{
	$arr=array(
		'code'=>400,
		'msg'=>'数据删除失败...'
	);
}

echo json_encode($arr);





