<?php 
/**
 * 此文件是导航菜单页面用来删除的接口
 */

//引用外部文件
include '../../../function.php';

//将数据库中的数据查询出来
$dataDB = select("select `value` from options where `key` = 'nav_menus'")[0]['value'];
//将字符串转为数组对象
$dataArr = json_decode($dataDB,true);

//获取传过来的索引
$index = $_GET['index'];
//根据传过来的索引删除对应的数据 array_splice(数组,索引,个数) -->删除一个元素，不保持索引
array_splice($dataArr,$index,1);

//将删除后的数据转为字符串
$newData = json_encode($dataArr,JSON_UNESCAPED_UNICODE);
//调用数据更新函数
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





