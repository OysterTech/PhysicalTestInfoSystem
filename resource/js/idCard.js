/**
 * idCard.js 检验证件号有效性JS
 * Created on 2018.06.06 by Jerry Cheung
 */

/**
* -----------------------------------
* checkValidIDCard 大陆二代身份证号码校验
* -----------------------------------
* @param INT 待校验的大陆二代身份证号码
* -----------------------------------
* @param Boolean 号码有效性
* -----------------------------------
**/
function checkValidIDCard(id) {
  var format = /^(([1][1-5])|([2][1-3])|([3][1-7])|([4][1-6])|([5][0-4])|([6][1-5])|([7][1])|([8][1-2]))\d{4}(([1][9]\d{2})|([2]\d{3}))(([0][1-9])|([1][0-2]))(([0][1-9])|([1-2][0-9])|([3][0-1]))\d{3}[0-9xX]$/;
  
  // 号码规则校验
  if(!format.test(id)){
    return false;
  }

  // 出生年月日校验
  year=id.substr(6,4);
  month=id.substr(10,2);
  day=id.substr(12,2);
  date=month+'-'+day+'-'+year;
  time=Date.parse(date);
  now_time=Date.parse(new Date());
  days=(new Date(year,month,0)).getDate();
  if(time>now_time || day>days){
    return false;
  }
  
  // 第18位校验码判断
  c=new Array(7,9,10,5,8,4,2,1,6,3,7,9,10,5,8,4,2);
  b=new Array('1','0','X','9','8','7','6','5','4','3','2');
  id_array=id.split("");
  sum = 0;
  for(k=0;k<17;k++){
    sum+=parseInt(id_array[k])*parseInt(c[k]);
  }
  if(id_array[17].toUpperCase() != b[sum%11].toUpperCase()){
    return false;
  }
  return true;
}


/**
* -----------------------------------
* checkValidHKID 香港身份证号码校验
* -----------------------------------
* @param INT 待校验的香港身份证号码
* -----------------------------------
* @param Boolean 号码有效性
* -----------------------------------
**/
function checkValidHKID(str) {
  strValidChars="ABCDEFGHIJKLMNOPQRSTUVWXYZ";

  // basic check length
  if(str.length<8){
    return false;
  }  
  
  // convert to upper case
  str=str.toUpperCase();

  // regular expression to check pattern and split
  hkidPat=/^([A-Z]{1,2})([0-9]{6})([A0-9])$/;
  matchArray=str.match(hkidPat);

  // not match, return false
  if(matchArray==null){
   return false;
  }
  
  // the character part, numeric part and check digit part
  charPart=matchArray[1];
  numPart=matchArray[2];
  checkDigit=matchArray[3];

  // calculate the checksum for character part
  checkSum=0;
  if(charPart.length==2){
    checkSum+=9*(10+strValidChars.indexOf(charPart.charAt(0)));
    checkSum+=8*(10+strValidChars.indexOf(charPart.charAt(1)));
  }else{
    checkSum+=9*36;
    checkSum+=8*(10+strValidChars.indexOf(charPart));
  }

  // calculate the checksum for numeric part
  for(i=0,j=7;i<numPart.length;i++,j--){
    checkSum+=j*numPart.charAt(i);
  }
  
  // verify the check digit
  remaining=checkSum % 11;
  verify=remaining==0?0:11-remaining;

  return verify==checkDigit || (verify == 10 && checkDigit=='A');
}
