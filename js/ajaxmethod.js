 // JavaScript Document
 var XHR;    //定义一个全局对象
 function createXHR(){              //首先我们得创建一个XMLHttpRequest对象
     if(window.ActiveXObject){//IE的低版本系类
         XHR=new ActiveXObject('Microsoft.XMLHTTP');//之前IE垄断了整个浏览器市场，没遵循W3C标准，所以就有了这句代码。。。但IE6之后开始有所改观
     }else if(window.XMLHttpRequest){//非IE系列的浏览器，但包括IE7 IE8
         XHR=new XMLHttpRequest();
     }
 }
 
 function checkEmail(){
	
	var temail = document.getElementById("email");
	var temail_label = document.getElementById("email_des");
	if(temail.value.replace(/(^s*)|(s*$)/g,"").length == 0){
		temail_label.innerText = "请输入联系人电子邮箱";
		temail_label.style.color = "red";
		return temail_label.innerText;
	}
	//对电子邮件的验证
    var myreg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
    if(!myreg.test(temail.value))
    {
		temail_label.innerText = "请输入有效的电子邮箱地址";
		temail_label.style.color = "red";
        return temail_label.innerText;
    }
	createXHR();
	XHR.open("GET","checkusrname.php?id="+temail.value,false);
	//true:表示异步传输，而不等send()方法返回结果，这正是ajax的核心思想, false 表示同步
	//我们不推荐使用 async=false，但是对于一些小型的请求，也是可以的。
	//请记住，JavaScript 会等到服务器响应就绪才继续执行。如果服务器繁忙或缓慢，应用程序会挂起或停止。
	//注释：当您使用 async=false 时，请不要编写 onreadystatechange 函数 - 把代码放到 send() 语句后面即可：
	XHR.send(null);
	if(XHR.readyState == 4){//关于Ajax引擎对象中的方法和属性，可以参考下面文章：http://www.jb51.net/article/29012.htm
         if(XHR.status == 200){    
             var textHTML=XHR.responseText;            
             document.getElementById('email_des').innerHTML=textHTML;
			 if(textHTML=="<font color=red>用户名已存在</font><a href=\"login.html\"> 登录</a>"){
				 return "用户名已存在";
			 }else if(textHTML=="<font color=green>用户名可以使用</font>"){
				 return "OK";
			 }
		}
    }
	
//	XHR.onreadystatechange=byhongfei	//当状态改变时，调用byhongfei这个方法，方法的内容我们另外定义
}

function checkNickname(){
	var tnickname = document.getElementById("nick_name").value;
	var tnickname_label = document.getElementById("nickname_des");
	if(tnickname.replace(/(^s*)|(s*$)/g,"").length == 0){
		tnickname_label.innerText = "请输入联系人昵称";
		tnickname_label.style.color = "red";
		return tnickname_label.innerText;
	}
	createXHR();
	XHR.open("GET","checknickname.php?nickname="+tnickname,false);
	XHR.send(null);
	if(XHR.readyState == 4){
		 if(XHR.status == 200){
			 var textHTML = XHR.responseText;
			 document.getElementById('nickname_des').innerHTML = textHTML;
			 if(textHTML=="<font color=red>昵称已存在</font>"){
				 return "昵称已存在";
			 }else if(textHTML=="<font color=green>昵称可以使用</font>"){
				 return "OK";
			 }
		 }
	}
//	XHR.onreadystatechange=showNickNameDes;
}

function checkYZM(){
	var tYZM = document.getElementById("yzm").value;
	createXHR();
	XHR.open("GET","checkYZM.php?YZM="+tYZM,false);
	XHR.send(null);
	if(XHR.readyState == 4){
		 if(XHR.status == 200){
			 var textHTML = XHR.responseText;
			 document.getElementById('YZM_des').innerHTML = textHTML;
			 if(textHTML=="<font color=red>验证码不正确</font>"){
				 return "验证码不正确";
			 }else if(textHTML=="<font color=green>验证码通过</font>"){
				 return "OK";
			 }
		 }
	}
//	XHR.onreadystatechange=showYZMDes;
	
} 
 
function delFile(filename)
{
//	alert(filename);
	createXHR();
	XHR.open("GET","delimage.php?filename="+filename,false);
	//true:表示异步传输，而不等send()方法返回结果，这正是ajax的核心思想, false 表示同步
	//我们不推荐使用 async=false，但是对于一些小型的请求，也是可以的。
	//请记住，JavaScript 会等到服务器响应就绪才继续执行。如果服务器繁忙或缓慢，应用程序会挂起或停止。
	//注释：当您使用 async=false 时，请不要编写 onreadystatechange 函数 - 把代码放到 send() 语句后面即可：
	XHR.send(null);
	if(XHR.readyState == 4){//关于Ajax引擎对象中的方法和属性，可以参考下面文章：http://www.jb51.net/article/29012.htm
         if(XHR.status == 200){    
             var textHTML=XHR.responseText;   
//			 alert(textHTML);
		}
	}
	window.location.reload();
}
 
 function byhongfei(){
     if(XHR.readyState == 4){//关于Ajax引擎对象中的方法和属性，可以参考下面文章：http://www.jb51.net/article/29012.htm
         if(XHR.status == 200){ 
			var textHTML = XHR.responseText;
			document.getElementById('YZM_des').innerHTML = textHTML;		 
            if(textHTML=="<font color=red>用户名已存在</font>"){
				 return "用户名已存在";
			 }else if(textHTML=="<font color=green>用户名可以使用</font>"){
				 return "OK";
			 }
		 }
     }
 }
 
 function showNickNameDes(){
	 if(XHR.readyState == 4){
		 if(XHR.status == 200){
			 var textHTML = XHR.responseText;
			 document.getElementById('nickname_des').innerHTML = textHTML;
		 }
	 }
 }
 
 function showYZMDes(){
	 if(XHR.readyState == 4){
		 if(XHR.status == 200){
			 var textHTML = XHR.responseText;
			 document.getElementById('YZM_des').innerHTML = textHTML;
		 }
	 }
 }
 
 function cancel_offer(offerID,reserveid){
	alert("offerID:"+offerID);
	alert("reserveID:"+reserveid);
	createXHR();
	XHR.open("GET","cancel_offer.php?offerID="+offerID+"&reserveid="+reserveid,false);
	//true:表示异步传输，而不等send()方法返回结果，这正是ajax的核心思想, false 表示同步
	//我们不推荐使用 async=false，但是对于一些小型的请求，也是可以的。
	//请记住，JavaScript 会等到服务器响应就绪才继续执行。如果服务器繁忙或缓慢，应用程序会挂起或停止。
	//注释：当您使用 async=false 时，请不要编写 onreadystatechange 函数 - 把代码放到 send() 语句后面即可：
	XHR.send(null);
	if(XHR.readyState == 4){//关于Ajax引擎对象中的方法和属性，可以参考下面文章：http://www.jb51.net/article/29012.htm
         if(XHR.status == 200){    
             var textHTML=XHR.responseText;   
			 alert(textHTML);
		}
	}
	window.location.reload();
//	alert("报价已取消!");
	
}

function accept_offer(reserveid,dgid,offer_price)
{
//	alert("reserveid:"+reserveid+" driverID:"+dgid);
	createXHR();
	XHR.open("GET","accept_offer.php?reserveid="+reserveid+"&dgID="+dgid+"&offer_price="+offer_price,true);
	//true:表示异步传输，而不等send()方法返回结果，这正是ajax的核心思想, false 表示同步
	//我们不推荐使用 async=false，但是对于一些小型的请求，也是可以的。
	//请记住，JavaScript 会等到服务器响应就绪才继续执行。如果服务器繁忙或缓慢，应用程序会挂起或停止。
	//注释：当您使用 async=false 时，请不要编写 onreadystatechange 函数 - 把代码放到 send() 语句后面即可：
	XHR.send(null);
	if(XHR.readyState == 4){
		 if(XHR.status == 200){
			 var textHTML=XHR.responseText;   
			 alert(textHTML);
		 }
	}
	window.location.reload();
	alert("您接收了报价，如果本页面无改变，请刷新本页面。");
}

function decline_offer(reserveid,dgid,ORID)
{
	createXHR();
	XHR.open("GET","decline_offer.php?reserveid="+reserveid+"&dgID="+dgid+"&ORID="+ORID,true);
	//true:表示异步传输，而不等send()方法返回结果，这正是ajax的核心思想, false 表示同步
	//我们不推荐使用 async=false，但是对于一些小型的请求，也是可以的。
	//请记住，JavaScript 会等到服务器响应就绪才继续执行。如果服务器繁忙或缓慢，应用程序会挂起或停止。
	//注释：当您使用 async=false 时，请不要编写 onreadystatechange 函数 - 把代码放到 send() 语句后面即可：
	XHR.send(null);
	if(XHR.readyState == 4){
		 if(XHR.status == 200){
			 var textHTML=XHR.responseText;   
			 alert(textHTML);
		 }
	}
	window.location.reload();
	alert("您拒绝了报价，如果本页面无改变，请刷新本页面。");
}

function resendActiveMail(send_to,nick_name)
{
	alert("resendActiveMail,send to:"+send_to+" nick name:"+nick_name);
/*	createXHR();
	XHR.open("GET","resendActiveMail.php?send_to="+send_to+"&nick_name="+nick_name,true);	//	true 表示异步，不等结果返回，防止网页挂住
	XHR.send(null);
	if(XHR.readyState == 4){
		 if(XHR.status == 200){
			 var textHTML=XHR.responseText;   
			 alert(textHTML);
		 }
	}
	alert("激活邮件已发送！");
	*/
}

function addCurURL2Session()
{
	var url = parent.location.href;
	createXHR();
	XHR.open("GET","add_curURL2Session.php?url="+url,false);	//	true 表示异步，不等结果返回，防止网页挂住
	XHR.send(null);
	if(XHR.readyState == 4){
		 if(XHR.status == 200){
			 var textHTML=XHR.responseText;   
		//	 alert(textHTML);
		 }
	}else{
		alert("XHR.readyState !=4");
	}
}
