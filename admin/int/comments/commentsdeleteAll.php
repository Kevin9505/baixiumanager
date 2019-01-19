<?php 
/**
 * 此文件是评论页面批量删除的接口
 */
//引用外部文件
include '../../../function.php';

//接收传过来的数据
$id = $_GET['id'];


//调用删除函数
$res = delete("comments",$id);

//判断是否删除成功
if($res){
	$arr = array(
		'code'   =>   200,
		'msg'    =>   '数据删除成功...'
	);
}else{
	$arr = array(
		'code'   =>   400,
		'msg'    =>   '数据删除失败...'
	);
}

//返回数据
echo json_encode($arr);




