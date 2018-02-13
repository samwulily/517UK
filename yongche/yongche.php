<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <head>
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
	<meta name="description" content="英国接机" />
	<meta name="keywords" content="伦敦接机" /> 
    <title>英国接机，旅游</title>
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
	<style type="text/css" media="all">@import "../css/master.css";</style>
	<link rel="stylesheet" type="text/css" href="../css/tcal.css" />
	<script type="text/javascript" src="../js/tcal.js"></script> 

    <script>
	
var airportArr = [
		["AB217DU","阿伯丁机场"],
		["EH129DN","爱丁堡机场"],
		["B263QJ","伯明翰机场"],
		["DD21UH","邓迪机场"],
		["PA32SW","格拉斯哥机场"],
		["KA92PL","格拉斯哥普雷斯蒂克机场"],
		["M901QX","曼彻斯特机场"],
		["E162PX","伦敦城市机场（London city）"],
		["RH60NP","伦敦盖特维克机场（London Gatwick）"],
		["TW62GW","伦敦希斯罗机场（London Heathrow）"],
		["LU29LY","伦敦鲁顿机场（London Luton）"],
		["CM241QW","伦敦斯坦斯特德机场（London Stansted）"]
	];
	
var cityArr = [
		["aberdeen","阿伯丁"],
		["edinburgh","爱丁堡"],
		["birmingham,UK","伯明翰"],
		["dundee","邓迪"],
		["glasgow","格拉斯哥"],
		["manchester","曼彻斯特"],
		["london","伦敦"]
	];	

var tori_address;
var tori_address_select;
var tdes_address;
var tdes_address_select;
var tflight_number_tr;
var tcity_tr;
	
var map;
var geocoder;
var bounds = new google.maps.LatLngBounds();
var markersArray = [];

var wcity = "";

var destinationIcon = 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=D|FF0000|000000';
var originIcon = 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=O|FFFF00|000000';

function click_address(){
	alert("请输入您想要接车或到达的准确地址，如果不清楚，请输入邮编。比如，您可以输入 3 baker street aberdeen uk，依次为门牌号，街道名，城市名，国家名。或者邮编 AB217DU ");
}

function click_address_mark(){
	alert("您可以在这里输入起点或终点的标注或附近的明显建筑物。比如，您可以输入 Aberdeen University Library or Aberdeen Airport Exit");
}

function click_airport_station(){
	alert("接送机请加1镑进出机场费用。需要接机的朋友请拿好行李，准备离开机场航站楼时联系司机，司机可以在5分钟左右到达机场候机楼外等候，避免高昂的机场停车费用。请注意，接送机车辆在机场内只能停留10分钟，请朋友们抓紧时间上下车。谢谢您的理解和配合。");
}

function click_msg(){
	alert("比如，您可以输入，几位乘车人，几件行李，行李尺寸和重量，乘车人中有无残疾人，老人或者5岁以下小孩，以便我们更好的为您服务。");
}

function submitform(){
	alert("确定吗？");
	var tdate = document.getElementById("date").value;
	var tdis_person = document.getElementById("dis_person").value;
	var tactive_status = document.getElementById("active_status").value;
	if(tactive_status == "0"){
		alert("未激活用户不能发布需求，请激活！");
		return false;
	}
	if(tdate.replace(/(^s*)|(s*$)/g,"").length == 0){
		alert("请输入您的用车日期");
		return false;
	}
	if(tdis_person == "游客"){
		alert("游客不能提交需求，请登录或注册！");
		return false;
	}
	var tdingcheform = document.getElementById('dingcheform');
	tdingcheform.submit();
	
}

function ini_form(){
	tori_address = document.getElementById("ori_address");
	tdes_address = document.getElementById("des_address");
	tori_address_select = document.getElementById("ori_address_select");
	tdes_address_select = document.getElementById("des_address_select");
	tflight_number_tr = document.getElementById("flight_number_tr");
	tcity_tr = document.getElementById("city_tr");
	
	tori_address.style.display = "none";
	tori_address_select.style.display = "";
	tdes_address.style.display = "";
	tdes_address_select.style.display="none";
	tflight_number_tr.style.display = "";
	tcity_tr.style.display = "none";
}

function initialize() {
  var opts = {
    center: new google.maps.LatLng(55.53, 9.4),
    zoom: 10
  };
  map = new google.maps.Map(document.getElementById('map-canvas'), opts);
  geocoder = new google.maps.Geocoder();
  codeAddress("aberdeen");
}

function codeAddress(tmplocation) {
//  var location = 'aberdeen';
  geocoder.geocode( { 'address': tmplocation}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      map.setCenter(results[0].geometry.location);
      var marker = new google.maps.Marker({
          map: map,
          position: results[0].geometry.location
      });
    } else {
      alert('Geocode was not successful for the following reason: ' + status);
    }
  });
}

function calculateDistances() {
  var tyongchetype = document.getElementById("yongchetype").value;
  var origin2 = "";
  var destinationB = "";
  if(tyongchetype == "接机"){
	origin2 = document.getElementById("ori_address_select").value;
	destinationB = document.getElementById("des_address").value;
	wcity = origin2;
  }else if(tyongchetype == "送机"){
	origin2 = document.getElementById("ori_address").value;
	destinationB = document.getElementById("des_address_select").value;
	wcity = destinationB;
  }else if(tyongchetype == "其他短租"){
	origin2 = document.getElementById("ori_address").value;
	destinationB = document.getElementById("des_address").value;
	wcity = document.getElementById("city_select").value;
  }
  if(wcity == "AB217DU"){
	wcity = "aberdeen";
  }else if(wcity == "EH129DN"){
	wcity = "edinburgh";
  }else if(wcity == "E162PX"||wcity == "RH60NP"||wcity == "TW62GW"||wcity == "LU29LY"||wcity == "CM241QW"){
	wcity = "london"
  }else if(wcity == "B263QJ"){
	wcity = "birmingham";
  }else if(wcity == "DD21UH"){
	wcity = "dundee";
  }else if(wcity == "PA32SW"||wcity == "KA92PL"){
	wcity = "glasgow";
  }else if(wcity == "M901QX"){
	wcity = "manchester";
  }
  
//  var destinationB = document.getElementById("des_address").value; 
  var tdis_person = document.getElementById("dis_person").value;
//	var tdis_person = document.getElementById("dis_person").innerHTML;
//  var tphone = document.getElementById("phone").value;
//  var temail = document.getElementById("email").value;
  var tdate = document.getElementById("date").value;
  var thour = document.getElementById("hour").value;
  var tminute = document.getElementById("minute").value;
//  if(tdate.replace(/(^s*)|(s*$)/g,"").length == 0){
//	alert("请输入您的用车日期");
//	return false;
//  }
  if(origin2.replace(/(^s*)|(s*$)/g,"").length == 0){
	alert("请输入您想要的接车地址");
	return false;	
  }
  if(destinationB.replace(/(^s*)|(s*$)/g,"").length == 0){
	alert("请输入您的目的地地址");
	
	return false;
  }
  if(tdis_person.replace(/(^s*)|(s*$)/g,"").length == 0){
	alert("请输入联系人信息");
	return false;
  }
//  if(tphone.replace(/(^s*)|(s*$)/g,"").length == 0){
//	alert("请输入联系人电话号码");
//	return false;
//  }
//  if(temail.replace(/(^s*)|(s*$)/g,"").length == 0){
//	alert("请输入联系人电子邮箱");
//	return false;
// }

//  var emailPat=/^(.+)@(.+)$/;
//  var matchArray=temail.match(emailPat);
//  if(matchArray == null){
//	alert("请输入有效的电子邮箱地址");
//	return false;
//  }
  
  var currentDate = new Date();	//获取日期与时间	
    
  var arrDate = tdate.split("/");
  var inputTime = new Date(arrDate[2],(arrDate[0]-parseInt(1)),arrDate[1],thour,tminute,0);
  var inputTimeMS = inputTime.getTime();
  var currentDateMS = currentDate.getTime();
	
//  if((inputTimeMS-currentDateMS)/1000/60/60<=24){
//	alert("请您提前24小时预定，谢谢合作");
//	return false;
//  }
  
  var service = new google.maps.DistanceMatrixService();
  service.getDistanceMatrix(
    {
      origins: [origin2],
      destinations: [destinationB],
      travelMode: google.maps.TravelMode.DRIVING,
      unitSystem: google.maps.UnitSystem.METRIC,
      avoidHighways: false,
      avoidTolls: false
    }, callback);
}

function callback(response, status) {
  if (status != google.maps.DistanceMatrixStatus.OK) {
    alert('Error was: ' + status);
  } else {
	var alertmsg = '';
	var fee = '';
	var distance = '';
	var tyongchetype = document.getElementById("yongchetype").value;
    var origins = response.originAddresses;
    var destinations = response.destinationAddresses;
	var tdate = document.getElementById('date').value;
	var thour = document.getElementById('hour').value;
	var tminute = document.getElementById('minute').value;
	var tdis_person = document.getElementById('dis_person').value;
//	var tdis_person = document.getElementById('dis_person').innerHTML;
//	var tphone = document.getElementById('phone').value;
//	var temail = document.getElementById('email').value;
    var outputDiv = document.getElementById('outputDiv');
	var temailmsg = document.getElementById('emailmsg');
	var showdistance = document.getElementById('distance');
	var showtimecost = document.getElementById('timecost');
	var showprice = document.getElementById('price');
	var myprice = document.getElementById('myprice');
    outputDiv.innerHTML = '';
    deleteOverlays();
	
    for (var i = 0; i < origins.length; i++) {
      var results = response.rows[i].elements;
      addMarker(origins[i], false);
      for (var j = 0; j < results.length; j++) {
        addMarker(destinations[j], true);
		distance = parseFloat(results[j].distance.text);	//	This is the km
		if(distance<50){	//	里程小于50，按当地出租车价钱算
			if(wcity == "aberdeen"){
				distance = parseFloat(distance)*0.621371192*1760;
				if(parseFloat(distance)>950){
					fee = parseFloat(2.4) + parseFloat(((parseFloat(distance)-950)/180.5*0.2).toFixed(1));
				}else{
					fee = 2.4;
				}
			}else if(wcity == "edinburgh"){
				if(parseFloat(distance)*1000>2031){
					fee = parseFloat(4.1) + parseFloat(((parseFloat(distance)*1000-2031)/217*0.25).toFixed(1));
				}else{
					fee = 4.1;
				}
			}else if(wcity == "london"){
				if(parseFloat(distance)*1000>9717){
					fee = parseFloat(17.4) + parseFloat(((parseFloat(distance)*1000-9717)/88.5*0.2).toFixed(1));
				}else{
					fee = 17.4;
				}
			}else if(wcity == "birmingham"){
				if(parseFloat(distance)*1000>966){
					fee = parseFloat(3.6) + parseFloat(((parseFloat(distance)*1000-966)/1609*1.8).toFixed(1));
				}else{
					fee = 3.6;
				}
			}else if(wcity == "dundee"){
				if(parseFloat(distance)*1000>644){
					fee = parseFloat(3.02) + parseFloat(((parseFloat(distance)*1000-644)/1609*1.6).toFixed(1));
				}else{
					fee = 3.02;
				}
			}else if(wcity == "glasgow"){
				if(parseFloat(distance)*1000>844){
					fee = parseFloat(2.6) + parseFloat(((parseFloat(distance)*1000-844)/189*0.2).toFixed(1));
				}else{
					fee = 2.6;
				}
			}else if(wcity == "manchester"){
				if(parseFloat(distance)*1000>354){
					fee = parseFloat(2.3) + parseFloat(((parseFloat(distance)*1000-354)/1609*1.85).toFixed(1));
				}else{
					fee = 2.3;
				}
			}
		}else if(distance>=50&&distance<100){	//	里程大于50公里，小于100公里，按一公里一英镑算
			fee = distance;
		}else if(distance>=100){
			fee = parseFloat(distance)*0.9;
			if(fee < 100){
				fee = 100;
			}
		}else{
			fee = "无法确定";
		}
		
		//	计算夜间费用，拥堵时段费用
		/*
		if(parseFloat(thour)>=22.0||parseFloat(thour)<7.0){
			fee = parseFloat(1.4) * fee;
		}
		if(parseFloat(thour)>=8.0&&parseFloat(thour)<9.0){
			fee = parseFloat(1.2) * fee;
		}
		if(parseFloat(thour)>=11.0&&parseFloat(thour)<13.0){
			fee = parseFloat(1.2) * fee;
		}
		if(parseFloat(thour)>=15.0&&parseFloat(thour)<18.0){
			fee = parseFloat(1.2) * fee;
		}
		*/
		//	补足最低消费
		if(wcity == "aberdeen"){
			if(fee < 10){
				fee = 10.0;
			}
		}else if(wcity == "edinburgh"){
			if(fee < 15){
				fee = 15.0;
			}
		}else if(wcity == "london"){
			if(fee < 30){
				fee = 30.0;
			}
		}else if(wcity == "birmingham"){
			if(fee < 15){
				fee = 15.0;
			}
		}else if(wcity == "dundee"){
			if(fee < 10){
				fee = 10.0;
			}
		}else if(wcity == "glasgow"){
			if(fee < 15){
				fee = 15.0;
			}
		}else if(wcity == "manchester"){
			if(fee < 15){
				fee = 15.0;
			}
		}
		
		//	机场出入费
		if(tyongchetype == "接机"||tyongchetype == "送机"){
			if(wcity == "london"){
				fee += 2;
			}else {
				fee += 1.0;
			}
		}
		
		//	booking fee
		fee += 1.5;
		
		fee = parseFloat(fee).toFixed(0);
		
		showdistance.value = results[j].distance.text;
		showtimecost.value = results[j].duration.text;
		showprice.value = fee;
		myprice.value = fee;
		
		alertmsg += tdis_person+',您需要在'+tdate+' '+thour+':'+tminute+' 从 '+origins[i] + ' 到 ' + destinations[j]
            + ' 总共 ' + results[j].distance.text + ' 如果道路通畅，预计用时 '
            + results[j].duration.text + '预计费用' + fee + '英镑。'+' 请注意，此费用仅为估计报价，最终报价由司机报价为准。司机会通过您预留的电话和邮箱和您确认，祝您路途愉快！';
//		alert(alertmsg);
		temailmsg.value = alertmsg;
		alertmsg += '<br>'+'<input type=\"button\" value=\"确定订车\" onclick=\"submitform()\">';
		outputDiv.innerHTML += alertmsg;
      }
    }
  }
}

function addMarker(location, isDestination) {
  var icon;
  if (isDestination) {
    icon = destinationIcon;''
  } else {
    icon = originIcon; 
  }
  geocoder.geocode({'address': location}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      bounds.extend(results[0].geometry.location);
      map.fitBounds(bounds);
      var marker = new google.maps.Marker({
        map: map,
        position: results[0].geometry.location,
        icon: icon
      });
      markersArray.push(marker);
    } else {
      alert('Geocode was not successful for the following reason: '
        + status);
    }
  });
}

function deleteOverlays() {
  for (var i = 0; i < markersArray.length; i++) {
    markersArray[i].setMap(null);
  }
  markersArray = [];
}

function yongchetype_changed(){
	var tyongchetype = document.getElementById("yongchetype").value;
	
	if(tyongchetype == "接机"){
		tori_address.style.display = "none";
		tori_address_select.style.display = "";
		tdes_address.style.display = "";
		tdes_address_select.style.display = "none";
		tflight_number_tr.style.display = "";
		tcity_tr.style.display = "none";
	}else if(tyongchetype == "送机"){
		tori_address.style.display = "";
		tori_address_select.style.display = "none";
		tdes_address.style.display = "none";
		tdes_address_select.style.display = "";
		tflight_number_tr.style.display = "";
		tcity_tr.style.display = "none";
	}else if(tyongchetype == "其他短租"){
		tori_address.style.display = "";
		tori_address_select.style.display = "none";
		tdes_address.style.display = "";
		tdes_address_select.style.display = "none";
		tflight_number_tr.style.display = "none";
		tcity_tr.style.display = "";
	}
} 

function city_select_changed(){
	wcity = document.getElementById("city_select").value;
	codeAddress(wcity);
}

function ori_address_select_changed(){
	wcity = document.getElementById("ori_address_select").value;
	codeAddress(wcity);
}

function des_address_select_changed(){
	wcity = document.getElementById("des_address_select").value;
	codeAddress(wcity);
}

google.maps.event.addDomListener(window, 'load', initialize);

    </script> 
  </head>
  <body onload="ini_form();">
	
	<?php
	include '../dbconnect.php';
	session_start();
	$nick_name = "游客";
	if(isset($_SESSION['username'])){
		$link =mysql_connect($dbserver,$dbuser,$dbpwd)
			or die ("Could not connect server"); 
		mysql_select_db($dbname, $link) or die("database does not exist");
		mysql_query("set character set 'gbk'"); 
		mysql_query("set character set 'utf8'");
		$query = "select username,nick_name,active_status from user where username = '".$_SESSION['username']."'";
		$result = mysql_query($query,$link);
		$row = mysql_fetch_array($result); 
		if($row){ 
			$nick_name = $row['nick_name'];
			$active_status = $row['active_status'];
		}
	}

	?>
	
    <div id="content-pane">
      <div id="inputs">
		<table>
			<tr>
				<td><h2><a href="../index.php">网站首页</a></h2></td>
				<td><h2><a href="">固定活动</a></h2></td>
			</tr>
		</table>
		
		<h1>我要预定（打<font color="red" size=5>*</font>部分为必填部分）</h1>
		<table>
			<tr>
				<td onclick="click_airport_station()">机场，火车站接送注意事项(点我查看细节)</td>
			</tr>
		</table>
		<form id="dingcheform" action="add_reserve.php" method="post">
		<table border=1>
			<input type="hidden" name="active_status" id="active_status" value="<?php echo $active_status ?>">
			<input type="hidden" name="reserve_person" id="reserve_person" value="<?php echo $_SESSION['username'] ?>">    
			<tr>
				<td>用车类别</td>
				<td colspan="3">
					<select name="yongchetype" id="yongchetype" onchange="yongchetype_changed();">
						<option value="接机" selected>接机</option>
						<option value="送机">送机</option>
						<option value="其他短租">其他短租（搬家）</option>
					</select> 
				</td>
			</tr>
			<tr>
				<td>用车日期:</td>
				<td colspan="3">
					<input type="text" name="date" id="date" class="tcal" value="" />
					<font color="red" size=5>*</font>
				</td>
			</tr>
			<tr>
				<td>用车时间:</td>
				<td colspan="3">
					<select name="hour" id="hour">
						<script type="text/javascript"> 
						for (i = 0; i < 24; i++) 
						{ 
							document.write("<option value=\""+ i+ "\">"+i+"</option>"); 
							document.write("<br>") 
						} 
						</script> 
					</select>  
					<select name="minute" id="minute">
					<script type="text/javascript">
					for(j=0;j<6;j++){
						document.write("<option value=\""+j*10+"\">"+j*10+"</option>");
						document.write("<br>");
					}
					</script>
					</select>
					<font color="red" size=5>*</font>
				</td>
			</tr>
			<tr id="flight_number_tr">
				<td>航班号码</td>
				<td colspan="3"><input name="flight_number" id="flight_number" type="textbox" value=""></td>
			</tr>
			<tr id="city_tr">
				<td>选择城市</td>
				<td colspan="3">
					<select name="city_select" id="city_select" onchange="city_select_changed();">
						<script type="text/javascript">
							document.write("<option value=\"" + cityArr[0][0] + "\" selected>" + cityArr[0][1] +"</option>");
							for(var i=1;i<cityArr.length;i++){
								document.write("<option value=\"" + cityArr[i][0] + "\">" + cityArr[i][1] + "</option>");
							}
						</script> 
					</select>
				</td>
			</tr>
			<tr>
				<td>起点:</td>
				<td colspan="3">
					<select name="ori_address_select" id="ori_address_select" onchange="ori_address_select_changed();">
						<script type="text/javascript">
							document.write("<option value=\"" + airportArr[0][0] + "\" selected>" + airportArr[0][1] +"</option>");
							for(var i=1;i<airportArr.length;i++){
								document.write("<option value=\"" + airportArr[i][0] + "\">" + airportArr[i][1] + "</option>");
							}
						</script> 
					</select>
					<input name="ori_address" id="ori_address" type="textbox" value="">	
					<font color="red" size=5>*</font>
					<img src="../images/question.png" onclick="click_address(this)" width="20" height="20" border="0"/>
				</td>
			</tr>
			<tr>
				<td>起点备注:</td>
				<td colspan="3">
					<input name="ori_address_mark" id="ori_address_mark" type="textbox" value="">
					<img src="../images/question.png" onclick="click_address_mark(this)" width="20" height="20" border="0"/>
				</td>
			</tr>
			<tr>
				<td>终点:</td>
				<td colspan="3">
					<select name="des_address_select" id="des_address_select" onchange="des_address_select_changed();">
						<script type="text/javascript">
							document.write("<option value=\"" + airportArr[0][0] + "\" selected>" + airportArr[0][1] +"</option>");
							for(var i=1;i<airportArr.length;i++){
								document.write("<option value=\"" + airportArr[i][0] + "\">" + airportArr[i][1] + "</option>");
							}
						</script> 
					</select>
					<input name="des_address" id="des_address" type="textbox" value="">
					<font color="red" size=5>*</font>
					<img src="../images/question.png" onclick="click_address(this)" width="20" height="20" border="0"/>
				</td>
			</tr>
			<tr>
				<td>终点备注:</td>
				<td colspan="3">
					<input name="des_address_mark" id="des_address_mark" type="textbox" value="">
					<img src="../images/question.png" onclick="click_address_mark(this)" width="20" height="20" border="0"/>
				</td>
			</tr>
			<tr>
				<td>预定人:</td>
				<td colspan="3">
					<input name="dis_person" id="dis_person" type="textbox" value="<?php echo $nick_name?>" readonly="readonly">
				</td>
			</tr>
			
<!--			<tr>
				<td>电子邮箱:</td>
				<td><input name="email" id="email" type="textbox" value=""><font color="red" size=5>*</font></td>
			</tr>
-->			
			<tr>
				<td>服务留言:</td>
				<td colspan="3">
					<textarea name="msg" id="msg" rows="3" cols="30"></textarea>
					<img src="../images/question.png" onclick="click_msg(this)" width="20" height="20" border="0"/></td>
				</td>
			</tr>
			<tr>
				<td>预计里程</td>
				<td><input type="text" id="distance" name="distance" readonly="readonly" size="10"></td>
				<td>预计用时</td>
				<td><input type="text" id="timecost" name="timecost" readonly="readonly" size="10"></td>
			</tr>
			<tr>
				<td>参考报价</td>
				<td><input type="text" id="price" name="price" size="5" readonly="readonly">英镑</td>
				<td><font color="red">我的出价</font></td>
				<td><input type="text" id="myprice" name="myprice" size="5">英镑</td>
			</tr>
			<tr>
				<td></td>
				<td colspan="3"><input type="button" onclick="calculateDistances()" value="给我估价"></td>
			</tr>
		</table>
		<table>
			<tr>
				<td><div name="outputDiv" id="outputDiv"></div></td>
			</tr>
			<tr>
				<td><input type="hidden" name="emailmsg" id="emailmsg" value=""></td>
			</tr>
		</table>
		</form>
      </div>
    </div>
    <div id="map-canvas"></div>
	
  </body>
</html>

