<?php
ob_start();
session_start();
include("db_config.php");
ini_set('display_errors', 1);
if (!$_SESSION["username"]){
header('Location:login1.php?msg=3');
}
ini_set('display_errors', 1);
?>

<!-- Enable debug using ?debug=true" -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>OS interaction using SQL Injection - SQL Injection Training App</title>

    <link href="./css/htmlstyles.css" rel="stylesheet">
	</head>

  <body>
  <div class="container-narrow">
		
		<div class="jumbotron">
			<p class="lead" style="color:white">
				OS interaction using SQL Injection - Let's drop a shell!</a>
				</p>
		</div>
		
<?php
if (isset($_GET["user"])){
		$user = $_GET["user"];
		//$q2 = "SELECT * FROM users where (username='".$username."') AND (password = '".md5($pass)."')" ;
		//still vulnerable LOL
		//$q = sprintf("Select * from users where username = '".$user."'";
		$test = 1;
		$q = sprintf("Select fname, username, description from users where username = '%s'",
			mysqli_real_escape_string($con, $user)
		);
		mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);
		$stmt = mysqli_prepare($con, "SELECT fname, username, description FROM users WHERE username = ?");

		
		if ($stmt) {
		    mysqli_stmt_bind_param($stmt, "s", $user);
		    mysqli_stmt_execute($stmt);
		    $stmt->bind_result($username, $name, $descr);
		    mysqli_stmt_fetch($stmt);
		}


}//end if isset

?>		
		
		<div class="response">
		
			<p style="color:white">
			<table class="response">
			
			<tr>
				<td>
					Username:  
				</td>
				<td>
					<?php echo $username; ?>
				</td>
			</tr>

			<tr>
				<td>
					Name:  
				</td>
				<td>
					<?php echo $name; ?>
				</td>
			</tr>

			<tr>
				<td>
					Description: 
				</td>
				<td>
					<?php echo $descr; ?>
				</td>
			</tr>
			<tr>
				<td>
					Query:
				</td>
				<td>
					<?php echo $test; 
					echo $fname;
					echo $username;
					echo $desc;
?>
				</td>
			</tr>
			</table>
			</p>	

        </div>
    
        
		<br />
		
<?php
		if (isset($_GET['debug']))
		{
			if ($_GET['debug']=="true")
		{
			$msg="<div style=\"border:1px solid #4CAF50; padding: 10px\">".$q."</div><br />";
			echo $msg;
			}
		}

?>

	  
	  
	  <div class="footer">
	  <p><h4><a href="blindsqli.php?user=<?php echo $_SESSION['username'];?>">Profile</a> | <a href="logout.php">Logout</a> | <a href="index.php">Home</a><h4></p>
      </div>
	  
	  
	  <div class="footer">
	  <p><a href="https://appsecco.com">Appsecco</a> | Riyaz Walikar | <a href="https://twitter.com/riyazwalikar">@riyazwalikar</a></p>
      </div>

	</div> <!-- /container -->
  
</body>
</html>
