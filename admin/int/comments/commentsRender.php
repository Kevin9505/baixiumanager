<?php 
//引用外部文件
include '../../../function.php';


//数据库总条数
$count = select("select count(*) as count from comments")[0]['count'];

//获取当前页码数
$currentPage = isset($_GET['page'])?$_GET['page']:1;


//页面上一页显示的条数 默认 10
$pageSize = 10;

//总页码数
$totalPagesCount = ceil($count / $pageSize);

//查询的索引
$offset = ($currentPage - 1) * $pageSize;

//数据库查询语句
$sql = "select c.id,c.author,c.created,c.content,c.status,p.title from comments as c left join posts as p on c.post_id=p.id limit $offset,$pageSize";
//调用查询函数
$data = select($sql);

//判断是否查询成功
if(!empty($data)){
	$arr = array(
		'code'   =>  200,
		'msg'    =>  '数据查询成功...',
		'data'   =>  $data,
		'count'  =>  $totalPagesCount,
		'size'	 =>	 $currentPage
	);
}else{
	$arr = array(
		'code'	 =>  400,
		'msg'		 =>  '数据查询失败...'
	);
}

//输出
echo json_encode($arr);




