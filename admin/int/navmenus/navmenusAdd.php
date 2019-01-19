<?php 
/**
 * 此文件是导航菜单页面用来添加新的导航链接的接口
 */

//引用外部文件
include '../../../function.php';

//调用函数将数据库中的数据取出
$dataDB = select("select `value` from options where `key` = 'nav_menus'")[0]['value'];
//将字符串转为数组对象
$data = json_decode($dataDB,true);

//将传过来的数据追加到从数据库中获取的数组中
$data[] = $_POST;
//将数组转为字符串
$newData = json_encode($data,JSON_UNESCAPED_UNICODE);

//调用数据更新函数,将数据写入数据库
$res = updatePlus("update options set `value` = '$newData' where `key` = 'nav_menus'");

//判断是否更新成功
if($res){
	$arr = array(
		'code'  => 200,
		'msg'   => '数据更新成功...'
	);
}else{
	$arr = array(
		'code'  => 400,
		'msg'   => '数据更新失败...'
	);
}

//输出
echo json_encode($arr);





