<?php 
/**
 * 此文件是首页渲染站点内容统计的接口
 */

//引用外部文件
include '../../../function.php';

//调用查询函数
$postsCount = select("select count(*) as count from posts")[0]['count'];	// 文章总数
$draftedCount = select("select count(*) as count from posts where status = 'drafted'")[0]['count'];  //草稿总数
$categoryCount = select("select count(*) as count from categories")[0]['count'];	//分类总数
$commentCount = select("select count(*) as count from comments")[0]['count'];		//评论总数
$heldCount = select("select count(*) as count from comments where status = 'held'")[0]['count'];	//待审核总数

//准备数据返回
$arr = array(
	'code'  				=> 200,
	'mgs'   				=> '数据查询成功...',
	'postsCount'  => $postsCount,
	'draftedCount'	=> $draftedCount,
	'categoryCount' => $categoryCount,
	'commentCount'	=> $commentCount,
	'heldCount'			=> $heldCount
);

// 输出
echo json_encode($arr);









