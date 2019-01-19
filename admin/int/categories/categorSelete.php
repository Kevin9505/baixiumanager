<?php
/**
 * 此文件是分类页渲染所有分类的接口
 */

//引用外部文件
include '../../../function.php';

//调用函数
$data = select("select * from categories");

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





