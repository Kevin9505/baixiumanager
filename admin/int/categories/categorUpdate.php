<?php
/**
 * 此文件是分类页用来更新分类的接口
 */

//引用外部文件
include '../../../function.php';

// print_r($_POST);
// die;
//调用函数
$res = update("categories",$_POST);

//判断是否更新成功
if($res){
	$arr=array(
		'code'=>200,
		'msg'=>'数据更新成功...'
	);
}else{
	$arr=array(
		'code'=>400,
		'msg'=>'数据更新失败...'
	);
}

echo json_encode($arr);




