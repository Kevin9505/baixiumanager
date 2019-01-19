<?php 
/**
 * 此文件是网站设置页面用来保存设置的接口
 */

//引用外部文件
include '../../../function.php';

//改造数据  1 开启评论  0 不开启,不用勾选
$_POST['comment_status'] = isset($_POST['comment_status']) ? 1 : 0;
$_POST['comment_reviewed'] = isset($_POST['comment_reviewed']) ? 1 : 0;

//调用数据库连接函数
$conn = conn();

//循环遍历数组,进行数据更新 用反证法判断是否更新成功
$flag = true;

foreach ($_POST as $key => $value) {
	// print_r($key);  成功 -> true   失败 -> false
	$sql = "update options set `value` = '$value' where `key` = '$key'";
	$res = mysqli_query($conn,$sql);
	if(!$res){
		$flag = false;
		echo $sql;
		break;
	}
}

//准备数据返回
if($flag){
	$arr = array(
		'code'  => 200,
		'msg'   => '数据保存成功....'
	);
}else{
	$arr = array(
		'code'  => 400,
		'msg'   => '数据保存失败....'
	);
}

//输出
echo json_encode($arr,JSON_UNESCAPED_UNICODE);






