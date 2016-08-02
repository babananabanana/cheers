<!DOCTYPE html>
<html  lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>FTP</title>
	<style>
		.suc01 {color:#cc0000; font-size:20px; line-height:30px;}
		.suc02 {color:#0099ff; font-size:20px; line-height:30px;}
		.suc03 {color:#ff9900; font-size:20px; line-height:30px;}
		.suc04 {color:#000; font-size:20px; line-height:30px;}
		.suc05 {color:blue; font-size:20px; line-height:30px;}
	</style>
</head>
<body style="padding:20px;">
<h1>FTP用户索引</h1>
<?php
	$username = $_POST['username'];
	$password = $_POST['password'];
	$conn = ftp_connect("10.63.240.170");
	echo "<b class='suc02'>Ftp server connect success!</b>";
	ftp_login($conn,$username,$password);
	echo "<b class='suc02'>Ftp account login success!</b>"."<br />";
	echo "<b class='suc02'> Current User: </b><b class='suc03'>".$username."</b><br />";
	$curdir1 = $_GET['name'];
	//$curdir = ftp_pwd($conn);
	if ($curdir1 == "")
			$curdir = ftp_pwd($conn);
	else
			$curdir = $curdir1;				
	echo "<b class='suc02'>Current Directory:</b><b class='suc03'> ".$curdir."</b>";
	echo "<br />";
	chdir($curdir);
	$pathinfo = pathinfo($curdir);
	printf("<b class='suc02'>Basename:</b><b class='suc03'> %s</b> <br />",$pathinfo['basename']);

	echo "<br /><b class='suc04'>"."FileList "."</b><br />";
	echo "<form action='cgitest.cgi' method='get' >";
listDir($curdir);
function listDir($dir)
{
		if(is_dir($dir))
																													{
				if($dh = opendir($dir))
				{
						while(($file = readdir($dh)) != false)
						{
								if((is_dir($dir."/".$file)) && $file[0] != '.')
								{
									$cc = $dir. "/".$file;
									echo "<a href='login2.php?name=$cc'><font class='suc05'> ".$file."</font></a><br />";
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
		}
}
 echo "<input type='submit' value='Upload' style='margin-top:10px; 
 background:#32cd32; color:#fff; font-size:16px;border:none; width:120px; text-align:center; height:30px; font-weight:bold'></form>"
?>
</body>
</html>
