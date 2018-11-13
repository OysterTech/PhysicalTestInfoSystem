/**
 * advice.js 显示体质测试项目练习建议JS
 * Created on 2018.11.10 by Jerry Cheung
 */

var adviceContent=[];
adviceContent["height"]="身高";
adviceContent["weight"]="体重";
adviceContent["vital_capacity"]="肺活量";
adviceContent["stand_jump"]="立定跳远";
adviceContent["sit_reach"]="坐位体前屈";
adviceContent["50m_race"]="50米跑";
adviceContent["long_race"]="长跑";
adviceContent["pull_up"]="引体向上";
adviceContent["situp"]="仰卧起坐";

function showExerciseAdvice(fieldName,name){
	$("#fieldName").html("["+name+"]的练习建议");
	$("#adviceContent").html(adviceContent[fieldName]);
	$("#adviceModal").modal('show');
}
