<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<?php
include("phpmail_517.php");
$q1b = "����1����Ŀǰ��ס�ڣ�";
$q2b = "����2����ʹ�õ�����������ǣ� ";
$q3b = "����3�����ǣ� ";
$q4b = "����4���������䣿";
$q5b = "����5������ְҵ��";
$q6b = "����6����Ŀǰ��ͥ�ṹ��";
$q7b = "����7������ƽ�������룿 ";
$q8b = "����8���ոտ�����ҪȥӢ������ʱ����վ������ӡ����ʲô��";
$q9b = "����9���������վ�����������֪����ҪȥӢ�������ṩʲô������ ";
$q10b = "����10���������վ����֪����ҪȥӢ��������Ϊ���ṩ������";
$q11b = "����11�������ղ���ҪȥӢ������";
$q12b = "����12���������վ����������ҪȥӢ������Ҫ�Ľ���Щ�ط���������ɶ�ѡ��";
$q13b = "����13�� ������ʲô�������˵�ģ�";
$q1b = iconv("GB2312","UTF-8",$q1b);
$q2b = iconv("GB2312","UTF-8",$q2b);
$q3b = iconv("GB2312","UTF-8",$q3b);
$q4b = iconv("GB2312","UTF-8",$q4b);
$q5b = iconv("GB2312","UTF-8",$q5b);
$q6b = iconv("GB2312","UTF-8",$q6b);
$q7b = iconv("GB2312","UTF-8",$q7b);
$q8b = iconv("GB2312","UTF-8",$q8b);
$q9b = iconv("GB2312","UTF-8",$q9b);
$q10b = iconv("GB2312","UTF-8",$q10b);
$q11b = iconv("GB2312","UTF-8",$q11b);
$q12b = iconv("GB2312","UTF-8",$q12b);
$q13b = iconv("GB2312","UTF-8",$q13b);

$body = "";
$body = $body.$q1b.$_POST["q1"]."<br/>".$q2b.$_POST["q2"]."<br/>".$q3b.$_POST["q3"]."<br/>".$q4b.$_POST["q4"]."<br/>".$q5b.$_POST["q5"]."<br/>";
$body = $body.$q6b.$_POST["q6"]."<br/>".$q7b.$_POST["q7"]."<br/>".$q8b.$_POST["q8"]."<br/>".$q9b.$_POST["q9"]."<br/>".$q10b.$_POST["q10"]."<br/>";
$body = $body.$q11b.$_POST["q11"]."<br/>".$q12b.$_POST["q12h"].$_POST["q12a"]."<br/>".$q13b.$_POST["q13"];

echo $body."<br/>";

postmail_517("admin@517yingguo.cn","test",$body);

?>