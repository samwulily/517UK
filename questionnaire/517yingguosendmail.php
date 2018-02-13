<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<?php
include("phpmail_517.php");
$q1b = "问题1：您目前居住在？";
$q2b = "问题2：您使用的网络服务商是？ ";
$q3b = "问题3：您是？ ";
$q4b = "问题4：您的年龄？";
$q5b = "问题5：您的职业？";
$q6b = "问题6：您目前家庭结构？";
$q7b = "问题7：您的平均月收入？ ";
$q8b = "问题8：刚刚看到我要去英国网的时候，网站给您的印象是什么？";
$q9b = "问题9：浏览完网站后，您能清楚的知道我要去英国网是提供什么服务吗？ ";
$q10b = "问题10：浏览完网站后，您知道我要去英国网可以为您提供服务吗？";
$q11b = "问题11：您会收藏我要去英国网吗？";
$q12b = "问题12：浏览完网站后，您觉得我要去英国网需要改进哪些地方？（此题可多选）";
$q13b = "问题13： 您还有什么想对我们说的？";
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