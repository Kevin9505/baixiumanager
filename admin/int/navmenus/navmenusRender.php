<?php 
/**
 * 此文件是导航菜单页面用来渲染导航菜单的接口
 */

//引用外部文件
include '../../../function.php';

$sql = "select `value` from options where `key` = 'nav_menus'";

//调用查询函数
$data = select($sql);

//判断是否查询成功
if(!empty($data)){
	$arr = array(
		'code'   =>   200,
		'msg'    =>   '数据查询成功...',
		'data'   =>   json_decode($data[0]['value'],true)		//将字符串转为json对象
	);
}else{
	$arr = array(
		'code'   =>   400,
		'msg'    =>   '数据查询成功...'
	);
}

//输出
echo json_encode($arr);






