<?php
/**
 * @name 生蚝体测信息管理系统-Web-处理修改学生
 * @author Jerry Cheung <master@xshgzs.com>
 * @create 2018-11-11
 * @update 2018-11-11
 */

require_once '../../include/public.func.php';

$id=isset($_POST['id'])&&$_POST['id']!=""?$_POST['id']:die(returnAjaxData(0,"lackParam"));
$name=isset($_POST['name'])&&$_POST['name']!=""?$_POST['name']:die(returnAjaxData(0,"lackParam"));
$type=isset($_POST['type'])&&$_POST['type']!=""?$_POST['type']:die(returnAjaxData(0,"lackParam"));
$enrollYear=isset($_POST['enrollYear'])&&$_POST['enrollYear']!=""?$_POST['enrollYear']:die(returnAjaxData(0,"lackParam"));
$classNum=isset($_POST['classNum'])&&$_POST['classNum']!=""?$_POST['classNum']:die(returnAjaxData(0,"lackParam"));
$idNumber=isset($_POST['idNumber'])&&$_POST['idNumber']!=""?$_POST['idNumber']:die(returnAjaxData(0,"lackParam"));

$sql="UPDATE student SET name=?,type=?,enroll_year=?,class_num=?,id_number=? WHERE id=?";
$query=PDOQuery($dbcon,$sql,[$name,$type,$enrollYear,$classNum,$idNumber,$id]);

if($query[1]==1){
	die(returnAjaxData(200,"success"));
}else{
	die(returnAjaxData(1,"error"));
}
