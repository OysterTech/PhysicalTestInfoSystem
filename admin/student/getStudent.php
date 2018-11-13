<?php
/**
 * @name 生蚝体测信息管理系统-Web-处理查学生
 * @author Jerry Cheung <master@xshgzs.com>
 * @create 2018-11-10
 * @update 2018-11-11
 */

require_once '../../include/public.func.php';

$orderBy=isset($_GET['orderBy'])&&$_GET['orderBy']!=""?$_GET['orderBy']:die(returnAjaxData(0,"lackParam"));
$studentSql="SELECT * FROM student WHERE is_delete=0 ";
$queryData=array();

// 根据搜索条件获取条件数据并拼接SQL语句
if($orderBy=="idNumber"){
	$idNumber=isset($_GET['idNumber'])&&$_GET['idNumber']!=""?$_GET['idNumber']:die(returnAjaxData(0,"lackParam"));
	$studentSql.="AND id_number=? ";
	$queryData=array($idNumber);
}elseif($orderBy=="className"){
	$name=isset($_GET['name'])&&$_GET['name']!=""?$_GET['name']:die(returnAjaxData(0,"lackParam"));
	$type=isset($_GET['type'])&&$_GET['type']!=""?$_GET['type']:die(returnAjaxData(0,"lackParam"));
	$enrollYear=isset($_GET['enrollYear'])&&$_GET['enrollYear']!=""?$_GET['enrollYear']:die(returnAjaxData(0,"lackParam"));
	$classNum=isset($_GET['classNum'])&&$_GET['classNum']!=""?$_GET['classNum']:die(returnAjaxData(0,"lackParam"));
	$studentSql.="AND a.name=? AND a.type=? AND a.enroll_year=? AND a.class_num=?";
	$queryData=array($name,$type,$enrollYear,$classNum);
}else{
	die(returnAjaxData(2,"invaildParam"));
}

$studentSql.="ORDER BY name,id";

// 查询成绩
$studentQuery=PDOQuery($dbcon,$studentSql,$queryData);
if($studentQuery[1]>=1){
	die(returnAjaxData(200,"success",['studentList'=>$studentQuery[0]]));
}else{
	die(returnAjaxData(1,"noStudent"));
}
