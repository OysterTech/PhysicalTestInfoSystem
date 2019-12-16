<?php
/**
 * @name 生蚝体测信息管理系统-Web-获取查成绩Token
 * @author Jerry Cheung <master@xshgzs.com>
 * @create 2018-11-19
 * @update 2018-12-15
 */

require_once 'include/public.func.php';

$orderBy=isset($_GET['orderBy'])&&$_GET['orderBy']!=""?$_GET['orderBy']:die(returnAjaxData(0,"lackParam"));
$studentSql="SELECT id,password FROM student WHERE is_delete=0 ";
$queryData=array();

// 根据搜索条件获取条件数据并拼接SQL语句
if($orderBy=="idNumber"){
	$idNumber=isset($_GET['idNumber'])&&$_GET['idNumber']!=""?$_GET['idNumber']:die(returnAjaxData(0,"lackParam"));
	$studentSql.="AND id_number=? ";
	$queryData=array($idNumber);
	$studentQuery=PDOQuery($dbcon,$studentSql,$queryData,[PDO::PARAM_INT]);
}elseif($orderBy=="className"){
	$name=isset($_GET['name'])&&$_GET['name']!=""?$_GET['name']:die(returnAjaxData(0,"lackParam"));
	$className=isset($_GET['className'])&&$_GET['className']!=""?$_GET['className']:die(returnAjaxData(0,"lackParam"));
	$studentSql.="AND name=? AND class_name=?";
	$queryData=array($name,$className);
	$studentQuery=PDOQuery($dbcon,$studentSql,$queryData,[PDO::PARAM_STR,PDO::PARAM_STR]);
}else{
	die(returnAjaxData(2,"invaildParam"));
}

// 查询学生

if($studentQuery[1]==1){
	$stuId=$studentQuery[0][0]['id'];
	$password=$studentQuery[0][0]['password'];
	$key=sha1(time().mt_rand(1234,9876));
	
	$showToken=sha1($key.$stuId);
	$serverToken=sha1($showToken.$password);
	
	$_SESSION['phyTest_stuId']=$stuId;
	$_SESSION['phyTest_searchToken']=$serverToken;
	
	die(returnAjaxData(200,"success",['token'=>$showToken]));
}else{
	die(returnAjaxData(1,"noStudent"));
}
