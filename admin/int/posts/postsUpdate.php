<?php
/**
 * 此文件是用来编辑文章页更新文章的接口
 */
//引用外部文件
include '../../../function.php';

//调用更新函数
$res = update("posts",$_POST);

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

//返回数据
echo json_encode($arr);





