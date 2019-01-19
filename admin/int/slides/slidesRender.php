<?php 
/**
 * 此文件是图片轮播页面用来渲染的接口
 */

//引用外部文件
include '../../../function.php';

//调用函数查询数据
$dataDB = select("select `value` from options where `key` = 'home_slides'")[0]['value'];

//将字符串转为json对象
$newData = json_decode($dataDB,true);


//准备数据返回
$arr = array(
	'code'   => 200,
	'msg'    => '数据查询成功...',
	'data'   => $newData
);

//输出
echo json_encode($arr);






