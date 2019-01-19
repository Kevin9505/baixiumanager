<?php 
/**
 * 此文件是用来添加分类页添加新的分类的接口
 */

//引用外部文件
include '../../../function.php';


//调用函数
$data = add("categories",$_POST);

//判断是否添加成功
if($data){
	$arr=array(
		'code'=>200,
		'msg'=>'数据添加成功...'
	);
}else{
	$arr=array(
		'code'=>200,
		'msg'=>'数据添加失败...'
	);
}

echo json_encode($arr);



