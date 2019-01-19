<?php
/**
 * 此文件是用来封装常用的方法
 * 数据库的增删改查
 * 封装的原则  函数越小越好,功能越单一越好,在调用的时候,能够高效的完成功能即可
 * 后期维护只更新对应的函数,不会对其他函数造成影响
 */

//引用外部文件  用php提供的魔法常量 __DIR__ 来找到该文件的根目录
require __DIR__.'\config.php';

//////////////////////
//1. 封装数据库连接函数 //
/////////////////////
function conn(){
	//创建数据库连接
	$conn=mysqli_connect(DB_HOST,DB_HOSTNAME,DB_HOSTPASSWORD,DB_DATABASESNAME);
	//判断数据库是否连接成功
	if(!$conn) die('数据库连接失败,请重试...');
	//如果连接成功,将连接结果返回
	return $conn;
}

///////////////////////////////////////////////
//2. 封装数据 查询 函数	传入参数 $sql 数据库查询语句 //
///////////////////////////////////////////////
function select($sql){
	//连接数据库
	$conn=conn();
	//查询数据,返回一个结果集
	$res=mysqli_query($conn,$sql);
	// var_dump($res);
	// die;
	if($res->num_rows){  //当数据 >=1 时执行
		while($row=mysqli_fetch_assoc($res)){
			$data[]=$row;	//定义数组储存查询到的数据
		}
	}else{	//当数据为 0 时执行
		$data = [];
	}
	
	//断开数据库连接
	mysqli_close($conn);

	//返回数据
	return $data;	
	
}

////////////////////////////////////////////////////////////////
//3. 封装 添加 用户数据的函数  传入参数 $table $arr->要添加的数据 //
////////////////////////////////////////////////////////////////
function add($table,$arr){
	//调用函数,连接数据库
	$conn=conn();

	//提取数组中的键   Array_keys(数组);	==>返回一组索引数组
	$keys=Array_keys($arr);
	//将数组拼接成字符串  implode("连接符",数组)  返回字符串
	$keystr=implode(',',$keys);

	//提取数组中的值   Array_values(数组)   ==>返回索引数组
	$values=Array_values($arr);
	//将数组拼接成字符串  implode("连接符",数组)  返回字符串
	$valuesstr=implode("','",$values);
	// email,slug,nickname,password 1980942486@qq.con','fsd','大叔','1111

	//数据库添加语句
	$sql="insert into $table ($keystr) values ('$valuesstr')";
	
	//添加到数据中		返回true 或 false
	$res=mysqli_query($conn,$sql);
	// die;
	//断开数据库的连接
	mysqli_close($conn);
	//将添加结果返回
	return $res;
}

//////////////////////////////////////////////
//4. 封装 删除 数据的函数    传入参数  $table  $id //
/////////////////////////////////////////////
function delete($table,$id){
	//调用数据库连接函数
	$conn=conn();
	//数据库删除语句
	$sql="delete from $table where id in ($id)";
	// echo $sql;
	// die;
	//删除数据
	$res = mysqli_query($conn,$sql);
	//断开数据库连接
	mysqli_close($conn);
	//返回删除结果
	return $res;
}

/////////////////////////////////////////////
//4. 封装 数据 更新函数 	传入参数  $table  $arr //
////////////////////////////////////////////
function update($table,$arr){
	//调用数据库连接函数
	$conn=conn();
	//数据库更新语句  $sql="update users set email='$email',slug='$slug',nickname='$nickname' where id=$id";

	//获取id
	$id=$arr['id'];
	//由于id是不用更新的,所以将id从数组中删除
	unset($arr['id']);

	//数据库更新语句
	$sql="update $table set ";

	//循环遍历数组
	foreach($arr as $key =>$val){
		$sql .= $key ."=" . "'$val'" .",";
	}

	//截取字符串  substr("字符串","开始","长度")
	$str=substr($sql,0,-1);		//update users set email='email',slug='slug',nickname='nickname'
	//完整的数据库更新语句
	$sql=$str ." where id=$id";		//update users set email='email',slug='slug',nickname='nickname' where id=13
	// print_r($sql);	//update users set email='1980942486@qq.com',slug='dada',nickname='大蜀黍' where id=13
	//修改数据,返回true或false
	$res=mysqli_query($conn,$sql);
	// var_dump($res);
	//断开数据库连接
	mysqli_close($conn);
	//将更新成功后的信息返回
	return $res;
}

/////////////////////////////////////
//5. 封装判断是否设置 session 的函数 //
/////////////////////////////////////
function setSession(){
	//开始session
	session_start();
	//判断是否设置了 session
	if(!$_SESSION['userInfo']){
		header("location:./login.php");
	}
}

///////////////////////////////////////
//6. 封装点击侧栏的按钮关闭侧边栏的函数 //
///////////////////////////////////////


///////////////////////////////////////////////////////////////////
//7. 封装不是根据 id 来更新数据的函数 -> 参数: 传入数据库更新语句 //
///////////////////////////////////////////////////////////////////
function updatePlus($sql){
	//调用链接函数
	$conn = conn();
	//更新数据
	$res = mysqli_query($conn,$sql);
	//关闭数据库
	mysqli_close($conn);
	//将更新成功后的结果返回
	return $res;
}
?>