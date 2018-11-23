<?php
/**
 * @name 生蚝体测信息管理系统-Web-处理查询成绩
 * @author Jerry Cheung <master@xshgzs.com>
 * @create 2018-11-10
 * @update 2018-11-20
 */

require_once 'include/public.func.php';

$scoreSql="SELECT a.class_name,a.name,b.* FROM student a,score b WHERE a.id=b.stu_id AND a.is_delete=0 ";
$queryData=array();
$scoreFieldList=array('height'=>'身高(单位cm)','weight'=>'体重(单位kg)','vital_capacity'=>'肺活量','stand_jump'=>'立定跳远(单位cm)','sit_reach'=>'坐位体前屈','50m_race'=>'50米跑(单位s)','long_race'=>'1000米(男)/800米(女)','pull_up'=>'引体向上(男)','situp'=>'仰卧起坐(女)','total_score'=>'总分');

$token=isset($_GET['token'])&&$_GET['token']!=""?$_GET['token']:die(returnAjaxData(0,"lackParam"));
$password=isset($_GET['password'])&&$_GET['password']!=""?$_GET['password']:die(returnAjaxData(0,"lackParam"));

if(sha1($token.$password)!=$_SESSION['phyTest_searchToken']){
	die(returnAjaxData(403,"invaildPassword"));
}else{
	$stuId=$_SESSION['phyTest_stuId'];
}

$scoreSql.="AND a.id=? ORDER BY b.year DESC";
$queryData=array($stuId);

// 查询成绩
$scoreQuery=PDOQuery($dbcon,$scoreSql,$queryData);
if($scoreQuery[1]>=1){
	die(returnAjaxData(200,"success",['scoreFieldList'=>$scoreFieldList,'scoreList'=>$scoreQuery[0]]));
}else{
	die(returnAjaxData(1,"noScore"));
}
