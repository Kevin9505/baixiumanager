<?php 
/**
 * 此文件是所有文章页的渲染的接口
 */

//引用外部文件
include '../../../function.php';

//获取数据库中总数据条数
$count=select("select count(*) as count from posts");

//当前页码
// print_r($_GET['page']);
// die;
$page=isset($_GET['page'])?$_GET['page']:1;
// echo $page;
//每页显示文章的数量  默认为 10
$pageSize=10;

//总页数
$totalCount=ceil($count[0]['count']/$pageSize);
// print_r($totalCount);
//查询数据索引
$offset=($page-1)*$pageSize;


//调用函数
// $data = select("select * from posts");
$sql="select p.id,p.slug,p.title,p.feature,p.created,p.content,p.status,u.nickname,c.name from posts as p left join users as u on p.user_id=u.id left join categories as c on p.category_id=c.id limit $offset,$pageSize";

$data = select($sql);
$category = select("select * from categories");
// $status = select("select * from comments where ");
// print_r($status);
// die;
//判断是否查询成功
if(!empty($data)){
	$arr=array(
		'code'=>200,
		'msg'=>'数据查询成功...',
		'data'=>$data,
		'totalPagesCount'=>$totalCount,
		'category'=>$category
	);
}else{
	$arr=array(
		'code'=>200,
		'msg'=>'数据查询失败...'
	);
}

//输出
echo json_encode($arr);


