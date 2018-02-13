<?php


$jmail=new COM('JMail.Message')or die('无法调用Jmail组件');


$jmail->logging='true';

$jmail->From='admin@517yingguo.cn'; //发信人地址，也就是您的邮箱地址


$jmail->FromName='admin';//发信人名字，建议填写您的邮箱地址


$jmail->AddRecipient('samwulily@hotmail.co.uk');//收信人地址 
//AddRecipient('xxx@xxx.com'); 可以添加很多的 群发.


$jmail->Subject='PHP+Jmail测试发送邮件'; //邮件标题

$jmail->Body='PHP+Jmail测试发送邮件'; //邮件内容


$jmail->MailServerUserName='admin@517yingguo.cn';//如xxx@xxx.com，一般为您的邮件地址

$jmail->MailServerPassword='admin@517uk';//您的邮箱登陆密码


$jmail->Send('smtp.517yingguo.cn');//mail.my-1.cn为我们的邮局SMTP地址，需要进行身份认证
echo 发送成功;
?>


