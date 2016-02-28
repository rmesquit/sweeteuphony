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
	<script src="dist/id3-minimized.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="js/driver.js"> </script>
    
	

	
	<script>
        
		function loadID3tags()
		{
			var source = document.getElementById('src1');
			var inputFile = source.src;
			
			ID3.loadTags(inputFile, function() {
				  showTags(inputFile);
				}, {
				  tags: ["title","artist","album","picture"]
				});
		
		}
	
		function showTags(url) {
			var tags = ID3.getAllTags(url);
			console.log(tags);
			document.getElementById('title').textContent = tags.title || "";
			document.getElementById('artist').textContent = tags.artist || "";
			document.getElementById('album').textContent = tags.album || "";
			var image = tags.picture;
			if (image) {
				var base64String = "";
				for (var i = 0; i < image.data.length; i++) {
					base64String += String.fromCharCode(image.data[i]);
				}
				var base64 = "data:" + image.format + ";base64," + window.btoa(base64String);
				document.getElementById('picture').setAttribute('src',base64);
			  } 
			else {
				document.getElementById('picture').style.display = "none";
			}
		}
		
		
	 
    </script>
	
</head>

<body onLoad="startTime = new Date(); setTimeout(display, 1000);">
    <!-- <div id="euphony-header"><center><h1><b>Euphony<b></h1></center></div> -->
	
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
				<li><a href="index.php?ac=logout"><?php echo $_SESSION['user_info']['name']  ?>: Sign Out</a></li>
				
			  </ul>
			</div>
		  </div>
		</nav>
	
	
	
                   
                   
	
	
    <div id="error_msg"> </div>
    <div id="content">
        <!-- show loading image when opening the page -->
		<center>
		<h3>Syncing...</h3> <br/>
		
		<script>
			// record start time
			var startTime;

			function display() {
				// later record end time
				var endTime = new Date();

				// time difference in ms
				var timeDiff = endTime - startTime;

				// strip the miliseconds
				timeDiff /= 1000;

				// get seconds
				var seconds = Math.round(timeDiff % 60);

				// remove seconds from the date
				timeDiff = Math.floor(timeDiff / 60);

				// get minutes
				var minutes = Math.round(timeDiff % 60);

				// remove minutes from the date
				timeDiff = Math.floor(timeDiff / 60);

				// get hours
				var hours = Math.round(timeDiff % 24);

				// remove hours from the date
				timeDiff = Math.floor(timeDiff / 24);

				// the rest of timeDiff is number of days
				var days = timeDiff;

				$(".time").text("Time elapsed: " + minutes +" mins, " + seconds + " secs");
				setTimeout(display, 1000);
				}


		
		</script>
        <img src="images/loader.gif" width="150px" /> </center>
		<br/><center><div class="time" style="font-size: 20px"></div><center>
    </div>
    <script type="text/javascript">
       $(document).ready(function(){
		$.ajax({        // call php script
        url: 'loadSongs.php',
        type:'GET',
        
        contentType: 'html'
    }).success(function(data){
            // remove loading image and add content received from php 
        $('div#content').html(data);

    }).error(function(jqXHR, textStatus, errorThrown){
            // in case something went wrong, show error
        $('div#error_msg').append('Sorry, something went wrong: ' + textStatus + ' (' + errorThrown + ')');
    });
	});
    </script>

				<audio id="player" ontimeupdate="updateTime()"> <source id="src1" autoplay></source></audio>
<!-- Now Playing Div to show the current songs being played -->
<div id="now_playing_div">
<center>
		<table class="table" style="color: #FFF034; margin-bottom: 0px">
		<tbody>
			<tr id="progressbartime"> 
				<!-- Song Slider tracks progress on song time change, if you click it sets the distance into the song
						based on the percentage of where was clicked -->
				<td width="100%"><div id="songSlider" onclick="setSongPosition(this,event)"><div id="trackProgress"></div></div> 
			<div id="currentSongTimeElapsed" style="position: relative; float: left; font-size: 14px">0:00</div> <div id="currentSongDuration" style="float: right; font-size: 14px">0:00</div></td><tr>
				
			</tr>
		</tbody>
	</table>
	
	<table class="table" style="margin-bottom: 10px; background-color: black">
		<tr id="controls"> &nbsp; &nbsp; <button id="backwardButton" class="backward" onclick="backward()"> </button>&nbsp; &nbsp; &nbsp; &nbsp;  <button id="playButton" class="play" onclick="playPause('player')"> </button> &nbsp; &nbsp; &nbsp; &nbsp;<button id="stopButton" class="stop" onclick="stopSong();"> </button> &nbsp; &nbsp; &nbsp; &nbsp; <button id="forwardButton" class="forward" onclick="forward()"> </button> </tr>
	</table>
		<table class="table" style="color: #FFF034; margin-bottom: 3px">
		
			
			<tr id="song-metadata">
				
				<td> <img id="picture" width="75px" height="75px" alt= "" /> </td>
				<td>
					<b><output type="text" id="title" style="font-size: 16px;" class="truncate"></output>  </b>
					<output id="artist" style="font-size: 14px;" class="truncate"></output>  
					<output id="album" style="font-size: 12px;" class="truncate"></output>
				</td>
				
				
							
			</tr>

	</table>
	
	

	</center>
</div>
	
</body>
</html>