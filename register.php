<?php 
include "base.php"; 
?>
<html>
<head>
    <title> Euphony </title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="dist/id3-minimized.js" type="text/javascript"></script>
	<!-- Boostrap CDN -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-theme.min.css">
	<script type="text/javascript" src="js/jquery-1.12.0.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<!-- ID3 Retrieval Libary -->
	<script src="dist/id3-minimized.js" type="text/javascript"></script>
	<!-- Customized CSS and JavaScript for Euphony by Suvro Sudip -->
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="js/driver.js"> </script>
</head>

<body>	
	<div class="container"> 
		<nav class="navbar navbar-black">
		  <div class="container-fluid">
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				<span class="icon-bar">---</span>
				<span class="icon-bar">---</span>
				<span class="icon-bar">---</span> 
			  </button>
			  <a class="navbar-brand" href="#"><div id="logobrand"> <b> <center> Euphony </center> </b></div></a>
			</div>
			<div class="collapse navbar-collapse" id="myNavbar">
			  <ul class="nav navbar-nav navbar-right">
				<li><a href="register.php">Sign Up</a></li>
				<li><a href="index.php"> Login</a></li>
			  </ul>
			</div>
		  </div>
		</nav>
	<!-- php script for registering user -->
	<?php
	if(!empty($_POST['email']) && !empty($_POST['password']))
	{
		$email = mysql_real_escape_string($_POST['email']);
		$password = md5(mysql_real_escape_string($_POST['password']));
		$name = mysql_real_escape_string($_POST['name']);
		 
		 $checkusername = mysql_query("SELECT * FROM php_users_login WHERE email = '".$email."'");
		  
		 if(mysql_num_rows($checkusername) == 1)
		 {
			header( "refresh:5;url=register.php" );
			echo "<center> <h1>Error</h1> </center>";
			echo "<center> <p>Sorry, that email is taken. Please go a href=\"register.php\">back </a> and try again. </p> </center>";
			
		 }
		 else
		 {
			 
			$registerquery = mysql_query("INSERT INTO php_users_login (email, password, name) VALUES('".$email."', '".$password."', '".$name."')");
			
		   if($registerquery)
			{
				header( "refresh:5;url=index.php" );
				echo "<center><h1>Success</h1></center>";
				echo '<center><p>Your account was successfully created. Please <a href=\drag.php?email='.$email.'>click here to upload your files.</a>.</p></center>';
				mkdir('users/'.$email);
				
			}
			else
			{
				header( "refresh:5;url=register.php" );
				echo "<center><h1>Error</h1>";
				echo "<p>Sorry, your registration failed. Please go a href=\"register.php\">back </a> and try again.</p> </center>";  
						
			}       
		 }
	}
	else
	{
	?>
     
	 <center>
		<h2>Euphony, Sweet, Euphony!</h2>		
		<h3>Upload all your music files and access them from your Android, iPhone or PC.</h3>
	</center>
	
	<!-- The Inline makes the registration form centralized -->
	<div id="container" style="position: absolute; height: 200px;  width: 400px;  margin: -100px 0 0 -200px;   top: 50%;    left: 50%;">
	<center>     
	<div id="container" style="padding-left: 15px; width: 75%">
        <form class="login-form" method="post" action="register.php" name="registerform" id="registerform">
		<h2>Register Here: </h2><br/>
		<div id="form-content">
			<fieldset>
						
				<div class="group">
					<label for="name">Full Name:</label>
					<div> <input  class="form-control required" type="text" name="name" id="name" /> </div>
				</div>
				
				<div class="group"><br/>
					<label for="email">Email:</label>
					<div> <input  class="form-control required" type="text" name="email" id="email" /> </div>
				</div>
				
				<div class="group"><br/>
					<label for="password">Password:</label>
					<div> <input  class="form-control required" type="password" name="password" id="password" /><div>
				</div>
				
				<div class="group submit"><br/><br/>
					<label class="empty"></label>
					<div> <input type="submit" class="loginButton" name="register" id="register" value="Register" /> </div>
				</div>
				
			</fieldset>
		</div>
	    </form>
	
     </div>
	 </center>
	 </div>
	<?php } ?> <!--Ending the php script -->
</body>
</html>