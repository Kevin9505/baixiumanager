<?php 
/**
 * 此文件是写文章页特色图像的上传的接口
 */

//引用外部文件
include '../../../function.php';

//获取上传过来图片的名称
$name=$_FILES['feature']['name'];
//截取后缀
$ext=strrchr($name,'.');
//新的名称
$newName=uniqid().$ext;
//固定路径
$path="../static/uploads/$newName";
//更改临时路径
move_uploaded_file($_FILES['feature']['tmp_name'],"../../$path");

//准备返回的数据
$arr=array(
	'code'=>200,
	'msg'=>'图片上传成功...',
	'src'=>$path
);

//返回数据
echo json_encode($arr);


// print_r($_FILES);
// die;
// Array
// (
//     [feature] => Array
//         (
//             [name] => 5bbc9006a2c4a.png
//             [type] => image/png
//             [tmp_name] => C:\Windows\php696.tmp
//             [error] => 0
//             [size] => 3924
//         )

// )








