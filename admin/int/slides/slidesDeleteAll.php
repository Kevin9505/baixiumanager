<?php 
/**
 * 此文件是图片轮播页面用来批量删除的接口
 */

//引用外部文件
include '../../../function.php';

//调用查询函数,将数据库中的数据取出
$data = select("select `value` from options where `key` = 'home_slides'")[0]['value'];
//将字符串转为json对象
$dataArr = json_decode($data,true);

//获取传过来的数据
$index = $_GET['index'];
//循环遍历数组,在 $dataArr 数组中找到对应的数据删除
foreach ($index as $key => $val) {
	unset($dataArr[$val]);
}

//将删除成功后的数据转为字符串,写入数据库
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
		'code'  => 400,
		'msg'   => '数据删除失败...'
	);
}

//输出
echo json_encode($arr);



