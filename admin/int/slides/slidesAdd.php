<?php 
/**
 * 此文件是图片轮播页面用来添加新的轮播图的接口
 */

//引用外部文件
include '../../../function.php';

//
$data = select("select `value` from options where `key` = 'home_slides'")[0]['value'];

$dataArr = json_decode($data,true);

$dataArr[] = $_POST;

$newData = json_encode($dataArr,JSON_UNESCAPED_UNICODE);

$res = updatePlus("update options set `value` = '$newData' where `key` = 'home_slides'");

if($res){
	$arr = array(
		'code'  => 200,
		'msg'   => '数据添加成功...'
	);
}else{
	$arr = array(
		'code'  => 400,
		'msg'   => '数据添加成功...'
	);
}

echo json_encode($arr);








