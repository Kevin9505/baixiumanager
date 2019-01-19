<?php
/**
 * 此文件是用来登录页验证邮箱和密码的接口
 */

// 接收数据
$email=$_POST['email'];
$password=$_POST['password'];

//引用外部文件
include '../../../function.php';
//调用函数
$sql="select * from users where email='$email'";

$data=select($sql);

// print_r($data);
// die;
//
if(!empty($data)){
	if($password==$data[0]['password']){
		$arr=array(
			'code'=>200,
			'msg'=>'登录成功...'
		);
		//设置session
			session_start();		//设置session前先开启session
			$_SESSION['userInfo']=$data;	//
	}else{
		$arr=array(
			'code'=>400,
			'msg'=>'密码错误,请重试...'
		);
	}
}else{
	$arr=array(
		'code'=>400,
		'msg'=>'账号或密码错误'
	);
}
// print_r($_SESSION);
// die;
echo json_encode($arr);
// if($data=='数据库中数据为空...'){
// 	$arr=array(
// 		'code'=>401,
// 		'msg'=>$data
// 	);
// }else{
	//判断邮箱是否一致
	// if($email==$data[0]['email']){
	// 	$arr=array(
	// 		'code'=>200,
	// 		'msg'=>'邮箱正确...'
	// 	);
	// 	if($password==$data[0]['password']){
	// 		$arr=array(
	// 			'code'=>200,
	// 			'msg'=>'密码正确...'
	// 		);
	// 		//设置session
	// 		session_start();		//设置session前先开启session
	// 		$_SESSION['userInfo']=$data;	//
	// 	}else{
	// 		$arr=array(
	// 			'code'=>200,
	// 			'msg'=>'密码错误,请重试...'
	// 		);
	// 	}
	// }else{
	// 	$arr=array(
	// 		'code'=>400,
	// 		'msg'=>'邮箱错误,请重试...'
	// 	);
	// }
// }


// echo json_encode($arr);
// print_r($res);
// die;
// Array
// (
//   [0] => Array
//       (
//           [id] => 4
//           [slug] => 超级管理员
//           [email] => 1980942486@qq.com
//           [password] => 1111
//           [nickname] => 大叔
//           [avatar] => /static/uploads/avatar.jpg
//           [bio] => 
//           [status] => activated
//       )
// )








?>