<!DOCTYPE html>
<?php
	session_start();
?>
<html  lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta http-equiv="Expires" content="0"/>
	<meta http-equiv="Progma" content="no-cache"/>
	<meta http-equiv="cache-control" content="no-cache,must-revalidate"/>
	<title>FTP</title>
	<style>
		.suc01 {color:#cc0000; font-size:20px; line-height:30px;}
		.suc02 {color:#0099ff; font-size:20px; line-height:30px;}
		.suc03 {color:#ff9900; font-size:20px; line-height:30px;}
		.suc04 {color:#000; font-size:20px; line-height:30px;}
		.suc05 {color:blue; font-size:20px; line-height:30px;}
	</style>
	<script type="text/javascript">
	
		function changeform()
		{
			
		var form2=document.forms['form1'];
		form2.action='login_3.php';
		form2.method='post';
		form2.submit();
		}
	</script>
</head>
<body style="padding:20px;">
<h1>FTP用户索引</h1>
<?php
	//$_GET['name'] = "";
	
	/*($_SERVER['REQUEST_METHOD'] == 'POST') {
		if ((!empty($_POST['username'])) && (!empty($_POST['password']))){
			echo "fggggg";
			if(($_POST[username] == 'ytsw03') && ($_POST['password'] == '123456')) {*/
	/*session_start();
	if (!isset ($_SESSION['username'])){
		if(isset($_POST['username'])){
			$db = new mysqli("localhost","ytsw03","123","ftp");
			echo "done";
			if (mysqli_connect_errno()) {
				printf("conncet failed:%s\n",mysqli_connect_errno());
				exit();
			}
			$stmt = $db->prepare("SELECT username FROM users WHERE username = ? and password = ?");
			$stmt->bind_param('ss', $_POST['username'] ,$_POST['password']);
			echo "bind done";
			$stmt->execute();
			$stmt->store_result();
			if ($stmt->num_rows == 1) {
				$stmt->bind_result($username);
				$stmt->fetch();
				$_SESSION['username']=$username;
				//header("Location:login3.php");
				header("Location:../../ftp_cloud/ftp.html");
			}
		} else {
			require_once('../../ftp_cloud/ftp.html');
		}

		} else {
		echo "you are already logged into the site.";
	}*/

	
	session_cache_limiter('private');
	$cache_limiter=session_cache_limiter();
	session_cache_expire(30);
	$cache_expire = session_cache_expire();
	//session.use_cookies = 1 | 0;
	session_start();
	$_SESSION['username'] = $_POST['username'];
	$_SESSION['password'] = $_POST['password'];

	if (!isset ($_SESSION['username'])){
		ob_end_clean();
		header("Location:../../ftp_cloud/ftp_2.html");
		exit();
		
	}

	//session_destroy();

	/*if($_SERVER['REQUEST_METHOD'] == 'POST'){
	session_start();
	$_SESSION['username'] = $_POST['username'];
	$_SESSION['password'] = $_POST['password'];
	if (!isset ($_SESSION['username'])){
		//ob_end_clean();
		header("Location:../../ftp_cloud/ftp_2.html");
		exit();
	}
	}*/
	
	$username = $_POST['username'];
	$password = $_POST['password'];
	$conn = ftp_connect("10.63.240.251");
	echo "<b class='suc02'>Ftp server connect success!</b>";
	ftp_login($conn,$username,$password);
	echo "<b class='suc02'>Ftp account login success!</b>"."<br />";
	echo "<b class='suc02'> Current User: </b><b class='suc03'>".$username."</b><br />";
	$curdir1 = $_POST['name'];
	
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
	//echo "<form action='cgitest.cgi' method='get' >";
	echo "<form action='cgitest.cgi' method='get' id='form1' >";
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
echo "<input type='submit' value='Upload' style='margin-top:10px; 
 background:#32cd32; color:#fff; font-size:16px;border:none; width:120px; text-align:center; height:30px; font-weight:bold'></form>";
?>
</body>
</html>
