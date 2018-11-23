<?php
/**
 * @fieldName 生蚝体测信息管理系统-Web-处理修改成绩
 * @author Jerry Cheung <master@xshgzs.com>
 * @create 2018-11-17
 * @update 2018-11-17
 */

require_once '../../include/public.func.php';

$fieldName=isset($_POST['fieldName'])&&$_POST['fieldName']!=""?$_POST['fieldName']:die(returnAjaxData(0,"lackParam"));
$idNumber=isset($_POST['idNumber'])&&$_POST['idNumber']!=""?$_POST['idNumber']:die(returnAjaxData(0,"lackParam"));
$scoreNum=isset($_POST['score'])&&$_POST['score']!=""?$_POST['score']:die(returnAjaxData(0,"lackParam"));
$point=isset($_POST['point'])&&$_POST['point']!=""?$_POST['point']:die(returnAjaxData(0,"lackParam"));
$level=isset($_POST['level'])&&$_POST['level']!=""?$_POST['level']:die(returnAjaxData(0,"lackParam"));

$score=$scoreNum."|".$point."|".$level;

$sql="UPDATE score SET {$fieldName}=? WHERE stu_id=(SELECT id FROM student WHERE id_number=?)";
$query=PDOQuery($dbcon,$sql,[$score,$idNumber]);

if($query[1]==1){
	die(returnAjaxData(200,"success"));
}else{
	die(returnAjaxData(1,"error"));
}
