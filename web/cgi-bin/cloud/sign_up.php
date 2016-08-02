<!doctype html>
<html  lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>sign up</title>
<style>
		h1{
            color:#0ae;
            text-align:center;
        }
         body{padding:50px;}
		.suc01 {color:#cc0000; font-size:30px; line-height:40px;}
		.suc02 {color:#0099ff; font-size:30px; line-height:40px;}
		.suc03 {color:#ff9900; font-size:30px; line-height:40px;}
		.suc04 {color:#000; font-size:30px; line-height:40px;}
		.suc05 {color:blue; font-size:30px; line-height:40px;}
	</style>
</head>
<body>
<?php
$username = $_POST['username'];
$password = $_POST['password'];
$password2 = $_POST['password2'];
$db_host = "localhost";
$db_user = "ytsw03";
$db_pass = "123";
$db_name = "cloud";
$link = mysql _connect($db_host, $db_user, $db_pass)or die("连接失败".mysql_error());
mysql_select_db($db_name, $link);
$sql = "create table user(name varchar(12) not null, password int(12) not null)";
if(mysql_query($sql,$link)) 
 echo "table created successfully";
if($password == $password2)
	$insert = "insert into user(name,password) values ('$username','$password')";
else 
	header("Location:../../cloud/sign_up.html");
if(mysql_query($insert))
	echo "<b class='suc02'>Sign up successfully<br/>Welcome!</b>";
?>
</body>

</html>