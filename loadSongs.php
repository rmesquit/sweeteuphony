<?php
session_name('LoginForm');
@session_start();

error_reporting(0);
include("config.php");

?>


<html lang="en">
<head>
	<title> Euphony </title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="dist/id3-minimized.js" type="text/javascript"></script>
	<!-- Boostrap CDN -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-theme.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	
	<script src="dist/id3-minimized.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="js/driver.js"> </script>

    



</head>
<body>
<div class="container" style="font-color: #FFFFFF;">
	       
	<table id="songList" class="table" style="border-style: none">
		<tbody>
		<?php
		// include getID3() library (can be in a different directory if full path is specified)
		require_once('getid3/getid3.php');

		// Initialize getID3 engine
		$getID3 = new getID3;
		$email = $_SESSION['user_info']['email'];
		$DirectoryToScan = 'users/'.$email; // change to whatever directory you want to scan
		$dir = opendir($DirectoryToScan);
		//echo '<tr>';
		$countImage=1;
		while (($file = readdir($dir)) !== false) {
			if ($countImage%10==0)
			{
				$countImage++;
			}
			
			$FullFileName = realpath($DirectoryToScan.'/'.$file);
			//echo $FullFileName;
			if ((substr($file, 0, 1) != '.') && is_file($FullFileName)) {
				set_time_limit(30);
				
				$ThisFileInfo = $getID3->analyze($FullFileName);

				getid3_lib::CopyTagsToComments($ThisFileInfo);
				
				// output desired information in whatever format you want
				if(isset($ThisFileInfo['comments']['picture'][0])){
						$Image1='data:'.$ThisFileInfo['comments']['picture'][0]['image_mime'].';charset=utf-8;base64,'.base64_encode($ThisFileInfo['comments']['picture'][0]['data']);
					}
				echo '<a href="#image'.$countImage.'" onclick="updateSource('.$countImage.'); loadID3tags();"><tr id="'.$countImage.'0">';
				echo '<td><a href="#image'.$countImage.'" onclick="updateSource('.$countImage.'); loadID3tags();"><img style="display: inline" name="image'.$countImage.'" id="'.$countImage.'" data-value="users/'.$email.'/'.$file.'" width="45" height="50" src="'.$Image1.'"></output></a></td>';
				echo '<td><a href="#image'.$countImage.'" onclick="updateSource('.$countImage.'); loadID3tags();"><output type="text" class="truncateScript">' .htmlentities(!empty($ThisFileInfo['comments_html']['title'])  ? implode('<br>', $ThisFileInfo['comments_html']['title'])          : chr(160)).'<br/>';
				echo ''              .htmlentities(!empty($ThisFileInfo['comments_html']['artist']) ? implode('<br>', $ThisFileInfo['comments_html']['artist'])         : chr(160)).'<br/></td>';
				//echo ''.htmlentities(!empty($ThisFileInfo['playtime_string'])         ?                 $ThisFileInfo['playtime_string']                  : chr(160)).'</a></td>';
				$countImage++;
			}
			echo '</tr></a>';
			
		}
		
		
		?>
		
		</tbody>
	</table>
	<br/>
</div>

</body></html>