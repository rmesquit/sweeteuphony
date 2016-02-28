
<?php
session_name('LoginForm');
@session_start();

error_reporting(0);
include("config.php");

?>

<html>
<head>
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
	<!-- Third Party Upload API -->
	<link href="uploadfile.css" rel="stylesheet">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="jquery.uploadfile.min.js"></script>
</head>
<body>
	
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
				<li><a href="index.php?ac=logout"><?php echo $_SESSION['user_info']['name']?>Sign Out</a></li>
			  </ul>
			</div>
		  </div>
		</nav>
	
	<!-- This is the hidden file to receive the folder path from URL -->
	<input type="hidden" id="folderpath" value="<?php echo $_GET["email"]; ?>">
	
	<!-- Third Party File Uploader Script -->
	<div id="container" style="position: absolute; height: 200px;  width: 400px;  margin: -100px 0 0 -200px;   top: 50%;    left: 50%;">
	<div id="mulitplefileuploader">Upload</div>

	<div id="status"></div> <br/><br/>
	
	<center> Click <a href="index.php?ac=logout"> Here </a> after you are done uploading. </center>
	<script>
	$(document).ready(function()
	{
	var folderpath;
	folderpath = document.getElementById("folderpath").value;
	var settings = {
		url: "upload.php?email="+folderpath,
		dragDrop:true,
		fileName: "myfile",
		allowedTypes:"mp3,aac",	
		returnType:"json",
		 onSuccess:function(files,data,xhr)
		{
		   // alert((data));
		},
		showDelete:true,
		deleteCallback: function(data,pd)
		{
		for(var i=0;i<data.length;i++)
		{
			$.post("delete.php",{op:"delete",name:data[i]},
			function(resp, textStatus, jqXHR)
			{
				//Show Message  
				$("#status").append("<div>File Deleted</div>");      
			});
		 }      
		pd.statusbar.hide(); //You choice to hide/not.

	}
	}
	var uploadObj = $("#mulitplefileuploader").uploadFile(settings);


	});
	</script>
	<div>
</body>
</html>
