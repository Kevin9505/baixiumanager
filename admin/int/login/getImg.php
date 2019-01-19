<?php 
/**
 * 此文件是用来登录页面当邮箱输入成功时获取对应的图片的接口
 */

//引用外部文件
include '../../../function.php';
$email=$_GET['email'];
$res = select("select avatar from users where email='$email'");

// var_dump($res);
// die; 
if(!empty($res)){
	echo $res[0]['avatar'];
}else{
	echo "";
}



