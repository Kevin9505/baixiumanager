<?php 
/**
 * 此页面是所有评论页驳回的接口
 */

//引用外部文件
include '../../../function.php';

//接手传过来的数据
$id = $_GET['id'];

//获取对应id的数据
$data = select("select * from comments where id = $id")[0];

//修改数据
$data['status'] = 'rejected';

//将修改后的数据存回数据库
$res = update("comments",$data);

//准备数据返回
$arr = array(
	'code'  => 200,
	'msg'   => '评论驳回成功....'
);

//输出
echo json_encode($arr);






