<?php
session_name('LoginForm');
@session_start();
error_reporting(0);
include("config.php");
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
	
	<center>
		<h2>Euphony, Sweet, Euphony!</h2>
		<h3>Upload all your music files and access them from your Android, iPhone or PC.</h3>
	</center>
	
	<!-- PHP check for login -->
	<?php
		$error = '';
		if(isset($_POST['is_login'])){
			$sql = "SELECT * FROM ".$SETTINGS["USERS"]." WHERE `email` = '".mysql_real_escape_string($_POST['email'])."' AND `password` = '".md5(mysql_real_escape_string($_POST['password']))."'";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
			$user = mysql_fetch_assoc($sql_result);
			if(!empty($user)){
				$_SESSION['user_info'] = $user; // registering as logged in user with the session
				$query = " UPDATE ".$SETTINGS["USERS"]." SET last_login = NOW() WHERE id=".$user['id']; // Updating the last login info
				mysql_query ($query, $connection ) or die ('request "Could not execute SQL query" '.$query);
			}
			else{
				$error = 'Wrong email or password.';
			}
		}
		// Checking if logout is called
		if(isset($_GET['ac']) && $_GET['ac'] == 'logout'){
			$_SESSION['user_info'] = null;
			unset($_SESSION['user_info']);
		}
	?>		
	<!-- PHP Script and JavaScript to check current session and redirect to Music Player -->	
	<?php if(isset($_SESSION['user_info']) && is_array($_SESSION['user_info'])) { echo "<script type='text/javascript'>window.location.href = 'player.php';</script>";
        exit();?>
	<!-- PHP Script and Login Form if user is not signed in -->
	<?php } else { ?>
		<center><div id="container" style="width: 75%">
	    <form id="login-form" class="login-form" name="form1" method="post" action="index.php">
	    	<input type="hidden" name="is_login" value="1">
	        <div class="h1"><center>Log in</center></div>			
			<div id="form-content">
	            <div class="group">
						<div> <font color="white"> <a href="register.php"> Didn't register? Register Now </a> to use Euphony!</font> <br/><br/></div>
	                <label for="email">Email</label>
	                <div><input id="email" name="email" class="form-control required" type="email" placeholder="Email"></div>
	            </div>
	           <div class="group">
	                <label for="name">Password</label>
	                <div><input id="password" name="password" class="form-control required" type="password" placeholder="Password"></div>
	            </div>
	            <?php if($error) { ?>
	                <em>
						<label class="err" for="password" generated="true" style="display: block;"><?php echo $error ?></label>
					</em>
				<?php } ?>
	            <div class="group submit">
	                <label class="empty"></label>
	                <div><center><input class="loginButton" name="submit" type="submit" value="Log In"/></center> </div>
	            </div>
	        </div>
	        <div id="form-loading" class="hide"><i class="fa fa-circle-o-notch fa-spin"></i></div>
	    </form>
		</div> </center><!-- Container Div with Inline CSS Ends Here -->
	<?php } ?>   <!-- PHP Script to end the else logic -->
</div>	<!-- Container Div Ends Here -->
</body>
</html>