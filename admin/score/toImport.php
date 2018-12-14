<?php
/**
 * @name 生蚝体测信息管理系统-Web-后台导入成绩处理
 * @author Jerry Cheung <master@xshgzs.com>
 * @create 2018-11-11
 * @update 2018-11-11
 */

require_once '../../include/public.func.php';
checkLogin();

require_once '../../plugin/PHPExcel/PHPExcel.php';
require_once '../../plugin/PHPExcel/PHPExcel/IOFactory.php';
require_once '../../plugin/PHPExcel/PHPExcel/Reader/Excel5.php';

if(isset($_POST) && $_POST){
	$year=isset($_GET['year'])&&$_GET['year']!=""?$_GET['year']:die(returnAjaxData(0,"lackParam"));
	$dir="../../filebox/".$gamesId."/";
	
	foreach($_FILES['myfile']["error"] as $key => $error){
		if($error == UPLOAD_ERR_OK){
			$MIME=$_FILES['myfile']['type'][$key];
			$extension=getFileExtension($MIME);
			$name=date("YmdH")."-".$year.mt_rand(123,987)."-Score.".$extension;
			$tmp_name=$_FILES["myfile"]["tmp_name"][$key];

			if(file_exists($dir.$name)){
				$ret=returnAjaxData(1,"fileExists");
				die($ret);
			}else{
				move_uploaded_file($tmp_name,$dir.$name);
			}

		}elseif($_FILES["myfile"]["error"][$key]!="4"){
			$ret=returnAjaxData($_FILES["file"]["error"][$key],"unknownError");
			die($ret);
		}else{
			$ret=returnAjaxData(var_dump($_FILES["file"]["error"]),"unknownError");
			die($ret);
		}
	}
	
	if($extension=="xls"){
		$objReader=PHPExcel_IOFactory::createReader('Excel5');
	}elseif($extension=="xlsx"){
		$objReader=PHPExcel_IOFactory::createReader('Excel2007');
	}else{
		die(returnAjaxData(3,"invaildExtension"));
	}
	
	$objPHPExcel=$objReader->load($dir.$name);
	$Sheet=$objPHPExcel->getSheet(0);

	// 取得总行数
	$HighestRow=$Sheet->getHighestRow();
	// 成功导入数量
	//$successRows=0;
	// 提示需要标记的行数
	//$tipsRemarkRows=0;
	//$tipsRemarkNames=array();

	// 循环读取Excel文件
	//$shouldSuccessRows=$HighestRow-1;
	$studentSql="INSERT INTO student(name,id_number,type,enroll_year,class_num) VALUES ";
	$scoreSql="INSERT INTO score(stu_id,year,height,weight,vital_capacity,50m_race,stand_jump,sit_reach,long_race,pull_up,situp,total_score) VALUES ";

	for($i=2;$i<=$HighestRow;$i++){

		// 获取单元格内容
		$rank=$objPHPExcel->getActiveSheet()->getCell("P".$i)->getValue();
		$name=$objPHPExcel->getActiveSheet()->getCell("V".$i)->getValue();
		$score=$objPHPExcel->getActiveSheet()->getCell("AC".$i)->getValue();
		$point=$objPHPExcel->getActiveSheet()->getCell("R".$i)->getValue();
		$allroundPoint=$objPHPExcel->getActiveSheet()->getCell("AD".$i)->getValue();
	}

//	$studentQuery=PDOQuery($dbcon,$studentSql);
//	$scoreQuery=PDOQuery($dbcon,$scoreSql);

	if(($HighestRow-1)==$scoreQuery[1]){
		$ret=returnAjaxData(200,"success");
		die($ret);
	}else{
		$ret=returnAjaxData(0,"failed",['total'=>$HighestRow-1,'rows'=>$scoreQuery[1]]);
		die($ret);
	}
}else{
	die(returnAjaxData(400,"invaildRequest"));
}


function getFileExtension($MIME){
	$MIME_XLS="application/vnd.ms-excel";
	$MIME_XLSX="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet";

	if($MIME==$MIME_XLS){
		return "xls";
	}else if($MIME==$MIME_XLSX){
		return "xlsx";
	}else{
		return "";
	}
}

?>