<?php 
/**
 * 此文件是菜单导航页面用来批量删除的接口
 */

//引用外部函数
include '../../../function.php';

//接收传过来的数据
$index = $_GET['index'];

//查询数据库中的数据
$dataDB = select("select `value` from options where `key` = 'nav_menus'")[0]['value'];


//将字符串转为数组
$dataArr = json_decode($dataDB,true);

// $str = json_encode($dataArr,JSON_UNESCAPED_UNICODE);
// print_r($str);
// die;
//循环遍历数组,删除对应的项
foreach($index as $key => $val){
		unset($dataArr[$val]);
}

//将删除后的数据转为字符串,写入数据库
$newData = json_encode($dataArr,JSON_UNESCAPED_UNICODE);

$res = updatePlus("update options set `value` = '$newData' where `key` = 'nav_menus'");

//判断是否更新成功
if($res){
	$arr = array(
		'code'   => 200,
		'msg'    => '数据删除成功...'
	);
}else{
	$arr = array(
		'code'   => 400,
		'msg'    => '数据删除失败...'
	);
}

//输出数据
echo json_encode($arr);






