<?php 
//引用外部文件
include '../../../function.php';

//调用更新数据的函数
$res = update("users",$_POST);

//判断是否更新成功
if($res){
	$arr=array(
		'code'=>200,
		'msg'=>'密码修改成功...'
	);
}else{
	$arr=array(
		'code'=>400,
		'msg'=>'密码修改失败...'
	);
}

echo json_encode($arr);




