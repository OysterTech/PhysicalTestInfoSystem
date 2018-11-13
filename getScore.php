<?php
/**
 * @name 生蚝体测信息管理系统-Web-处理查询成绩
 * @author Jerry Cheung <master@xshgzs.com>
 * @create 2018-11-10
 * @update 2018-11-12
 */

require_once 'include/public.func.php';

$orderBy=isset($_GET['orderBy'])&&$_GET['orderBy']!=""?$_GET['orderBy']:die(returnAjaxData(0,"lackParam"));
$scoreSql="SELECT a.class_name,a.name,b.* FROM student a,score b WHERE a.id=b.stu_id AND a.is_delete=0 ";
$queryData=array();
$scoreFieldList=array('height'=>'身高(单位cm)','weight'=>'体重(单位kg)','vital_capacity'=>'肺活量','stand_jump'=>'立定跳远(单位cm)','sit_reach'=>'坐位体前屈','50m_race'=>'50米跑(单位s)','long_race'=>'1000米(男)/800米(女)','pull_up'=>'引体向上(男)','situp'=>'仰卧起坐(女)','total_score'=>'总分');

// 根据搜索条件获取条件数据并拼接SQL语句
if($orderBy=="idNumber"){
	$idNumber=isset($_GET['idNumber'])&&$_GET['idNumber']!=""?$_GET['idNumber']:die(returnAjaxData(0,"lackParam"));
	$scoreSql.="AND a.id_number=? ";
	$queryData=array($idNumber);
}elseif($orderBy=="className"){
	$name=isset($_GET['name'])&&$_GET['name']!=""?$_GET['name']:die(returnAjaxData(0,"lackParam"));
	$className=isset($_GET['className'])&&$_GET['className']!=""?$_GET['className']:die(returnAjaxData(0,"lackParam"));
	$scoreSql.="AND a.name=? AND a.class_name=?";
	$queryData=array($name,$className);
}else{
	die(returnAjaxData(2,"invaildParam"));
}

$scoreSql.="ORDER BY b.year DESC";

// 查询成绩
$scoreQuery=PDOQuery($dbcon,$scoreSql,$queryData);
if($scoreQuery[1]>=1){
	die(returnAjaxData(200,"success",['scoreFieldList'=>$scoreFieldList,'scoreList'=>$scoreQuery[0]]));
}else{
	die(returnAjaxData(1,"noScore"));
}
