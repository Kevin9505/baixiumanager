<?php
/**
 * 此文件是用来退出登录时删除session文件的接口
 */

//开启session
session_start();
//删除session
unset($_SESSION['userInfo']);
//跳转
header("location:/admin/login.php");






