<?php 
/**
 * 此文件是写文章页的所属分类的接口
 */

//引用外部文件
include '../../../function.php';

//调用函数
$data=select("select * from categories");

//判断是否查询成功
if(!empty($data)){
	$arr=array(
		'code'=>200,
		'msg'=>'数据查询成功...',
		'data'=>$data
	);
}else{
	$arr=array(
		'code'=>200,
		'msg'=>'数据查询失败...'
	);
}


//输出
echo json_encode($arr);








