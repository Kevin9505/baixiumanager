<?php 
/**
 * 此文件是所有文章页文章删除接口
 */

//引用外部文件
include '../../../function.php';

// print_r($_GET);
// die;
//调用函数
$res = delete("posts",$_GET['id']);

//判断是否删除成功,准备返回的数据
if($res){
	$arr=array(
		'code'=>200,
		'msg'=>'数据删除成功...'
	);
}else{
	$arr=array(
		'code'=>200,
		'msg'=>'数据删除失败...'
	);
}

//返回数据
echo json_encode($arr);





