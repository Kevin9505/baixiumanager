<?php 
//引用外部文件
include '../../../function.php';

//获取传过来的id
$id=$_POST['id'];

//调用查询函数
$data = select("select password from users where id = $id");

if(!empty($data)){
	$arr=array(
		'code'=>200,
		'msg'=>'密码查询成功...',
		'data'=>$data
	);
}else{
	$arr=array(
		'code'=>200,
		'msg'=>'密码查询失败...'
	);
}

echo json_encode($arr);



