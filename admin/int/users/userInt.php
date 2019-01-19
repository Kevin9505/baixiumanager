<?php 
/**
 * 此文件是用户页面用来渲染所有用户的接口
 */

// 引用外部文件
include('../../../function.php');
// 调用查询函数,查询数据  返回一个数组
$data = select('select * from users where flag = 0');
//判断查询结果,将查询到的数据返回  要遵循一定的返回格式   code  msg  data
if(is_array($data)){
	$arr=array(
		"code"=>200,		//状态码
		"msg"=>"数据查询成功...",	//状态描述
		"data"=>$data		//数据
	);
}else{
	$arr=array(
		"code"=>400,		//状态码
		"msg"=>"数据查询失败,请重试...",	//状态描述
		"data"=>$data		//数据
	);
}

//返回数据
echo json_encode($arr);
?>