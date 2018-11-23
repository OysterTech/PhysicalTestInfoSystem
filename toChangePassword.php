<?php
/**
 * @name 生蚝体测信息管理系统-Web-处理修改密码
 * @author Jerry Cheung <master@xshgzs.com>
 * @create 2018-11-22
 * @update 2018-11-22
 */

require_once 'include/public.func.php';

$sql="UPDATE student SET password=? WHERE id=?";$token=isset($_GET['token'])&&$_GET['token']!=""?$_GET['token']:die(returnAjaxData(0,"lackParam"));
$oldPwd=isset($_GET['oldPwd'])&&$_GET['oldPwd']!=""?$_GET['oldPwd']:die(returnAjaxData(0,"lackParam"));
$newPwd=isset($_GET['newPwd'])&&$_GET['newPwd']!=""?$_GET['newPwd']:die(returnAjaxData(0,"lackParam"));

if(sha1($token.$oldPwd)!=$_SESSION['phyTest_searchToken']){
	die(returnAjaxData(403,"invaildPassword"));
}else{
	$stuId=$_SESSION['phyTest_stuId'];
}

// 修改密码
$query=PDOQuery($dbcon,$sql,[$newPwd,$stuId]);
if($query[1]==1){
	die(returnAjaxData(200,"success"));
}else{
	die(returnAjaxData(2,"changeError"));
}
