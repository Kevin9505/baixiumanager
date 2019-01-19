<?php 
/**
 * 此文件是网站设置页面用来渲染的接口
 */

//引用外部文件
include '../../../function.php';

//调用查询函数将数据库中的数据取出
$data = select("select * from options where id < 9");
//将字符串转为json对象

// $dataArr = json_decode($data,true);
// print_r($dataArr);
// die;
//准备数据返回
$arr = array(
	'code'  => 200,
	'msg'   => '数据查询成功...',
	'data'  => $data
);

//输出
echo json_encode($arr);






