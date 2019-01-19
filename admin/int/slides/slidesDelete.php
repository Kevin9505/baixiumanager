<?php 
/**
 * 此文件是图片轮播页面用来删除轮播图的接口
 */

//引用外部文件
include '../../../function.php';

//调用查询函数查询数据库中的数据
$data = select("select `value` from options where `key` = 'home_slides'")[0]['value'];
//将字符串转为json对象
$dataArr = json_decode($data,true);

//根据传过来的索引值删除对应的数据
array_splice($dataArr,$_GET['index'],1);

//将删除后的数据转为字符串存入数据库中
$newData = json_encode($dataArr,JSON_UNESCAPED_UNICODE);
$res = updatePlus("update options set `value` = '$newData' where `key` = 'home_slides'");

//判断是否更新成功
if($res){
	$arr = array(
		'code'  => 200,
		'msg'   => '数据删除成功...'
	);
}else{
	$arr = array(
		'code'  => 200,
		'msg'   => '数据删除成功...'
	);
}

//输出
echo json_encode($arr);


