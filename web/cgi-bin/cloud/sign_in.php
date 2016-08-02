<?php
	session_start();
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8"/>
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
<script type="text/javascript">
	
		function changeform()
		{
			
		var form2=document.forms['form1'];
		form2.action='sign_in.php';
		form2.method='post';
		form2.submit();
		}
</script>
</head>
<body>
<h1>用户索引</h1>
<?php
header('Cache-control:private,must-revalidate');
session_start();
	$_SESSION['username'] = $_POST['username'];
	$_SESSION['password'] = $_POST['password'];

	if (!isset ($_SESSION['username'])){
		ob_end_clean();
		header("Location:../../cloud/sign_in.html");
		exit();
		
	}
$username = $_POST['username'];
$password = $_POST['password'];
$db_host = "localhost";
$db_user = "ytsw03";
$db_pass = "123";
$db_name = "cloud";
$link = mysql_connect($db_host, $db_user, $db_pass)or die("连接失败".mysql_error());
mysql_select_db($db_name, $link);
$select = "select * from user";
$result = mysql_query($select, $link);
$row=mysql_fetch_array($result);
if(($username== $row[name]) && ($password == $row[password]))
	echo "<b class='suc02'>Login successfully!<br/>Welcome Back!</b>";
else
	header("Location:../../cloud/sign_in.html");
$curdir1 = $_POST['name'];
echo "<br />";
//system("/kscloud");
//$curdir = "/kscloud";
//chdir($curdir);
//echo $curdir1;
//chdir($curdir);
if ($curdir1 == ""){
			//echo "<br /><b class='suc04'>"."FileList "."</b><br />";
			//$curdir = system("cd  /kscloud");
			$curdir = "/kscloud";

}
else
			$curdir = $curdir1;	
	echo "<br />";
	chdir($curdir);
	echo "<br /><b class='suc04'>"."FileList "."</b><br />";
	echo "<form action='cgitest.cgi' method='get' id='form1' >";
	listDir($curdir);
function listDir($dir)
{
		$username = $_POST['username'];
		$password = $_POST['password'];
		if(is_dir($dir))
		{
				if($dh = opendir($dir))
				{
						while(($file = readdir($dh)) != false)
						{
								if((is_dir($dir."/".$file)) && $file[0] != '.')
								{
									$cc = $dir. "/".$file;
									//echo "<form method='post' action='login_3.php'>";
									echo "<input type='text' style='display:none;' name='name' value=$cc>";
									echo "<input type='text' style='display:none;' name='username' value=$username>";
									echo "<input type='text' style='display:none;' name='password' value=$password>";
									echo "<input type='submit' value=$file name=$file onclick='changeform();' style='border:none;font-size:20px; font-weight:bold;color:blue; text-decoration:underline;background-color:#fff;'>";
									echo "<br />";						
									
								}
								else
								{
										$cc = $dir. "/".$file;
										if( $file[0]=='.')
										continue ;
								
									echo "<input type='checkbox' name=$file value=$cc ><font class='suc04'>".$file."</font><br />";									
								}
						}
				}
				closedir($dir);
		}
}
echo "<input type='submit' value='upload to default dir' style='margin-top:10px; 
 background:#32cd32; color:#fff; font-size:14px;border:none; width:120px; text-align:center; height:30px; font-weight:bold'></form>";
echo "<input type='submit' value='choose  dir' style='margin-top:10px; 
 background:#32cd32; color:#fff; font-size:14px;border:none; width:120px; text-align:center; height:30px; font-weight:bold'></form>";
?>
</body>
</html>
