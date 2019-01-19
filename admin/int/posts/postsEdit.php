<?php 
/**
 * 此文件是所有文章页文章编辑接口
 */

//引用外部文件
include '../../../function.php';
$id = $_GET['id'];
//调用函数  --->查询文章内容
$contentData = select("select * from posts where id = $id");
$categorData = select("select * from categories");

//判断是否查询成功
if(!empty($contentData)){
	$arr=array(
		'code'=>200,
		'msg'=>'数据查询成功...',
		'contentData'=>$contentData,
		'categorData'=>$categorData
	);
}else{
	$arr=array(
		'code'=>200,
		'msg'=>'数据查询失败...'
	);
}

//返回数据
echo json_encode($arr);






