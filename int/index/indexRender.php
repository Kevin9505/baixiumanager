<?php 
/**
 * 此文件是前台页面渲染的接口
 */

//引用外部文件
include '../../function.php';

//调用查询函数
$data = select("select * from options");
$homeSlides = select("select `value` from options where `key` = 'home_slides'")[0]['value'];
$Slides = json_decode($homeSlides,true);
// print_r($Slides);
// die;

//判断是否查询成功
if(!empty($data)){
	$arr = array(
		'code'  => 200,
		'msg'   => '数据查询成功....',
		'data'  => $data,
		'homeSlides'=>$Slides
	);
}else{
	$arr = array(
		'code'  => 400,
		'msg'   => '数据查询失败....'
	);
}

//输出
echo json_encode($arr);







