<?php 
/**
 * 此文件是用来分类页删除分类的接口
 */

//引用外部文件
include '../../../function.php';

//调用函数
$res = delete("categories",$_GET['id']);

//判断是否删除成功
if($res){
	$arr=array(
		'code'=>200,
		'msg'=>'删除数据成功...'
	);
}else{
	$arr=array(
		'code'=>400,
		'msg'=>'删除数据失败...'
	);
}

echo json_encode($arr);





