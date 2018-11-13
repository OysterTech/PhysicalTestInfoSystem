<?php
/**
 * @name 生蚝体测信息管理系统-Web-处理删除学生
 * @author Jerry Cheung <master@xshgzs.com>
 * @create 2018-11-11
 * @update 2018-11-11
 */

require_once '../../include/public.func.php';

$id=isset($_POST['id'])&&$_POST['id']!=""?$_POST['id']:die(returnAjaxData(0,"lackParam"));

$sql="UPDATE student SET is_delete=1 WHERE id=?";
$query=PDOQuery($dbcon,$sql,[$id]);

if($query[1]==1){
	die(returnAjaxData(200,"success"));
}else{
	die(returnAjaxData(1,"error"));
}
