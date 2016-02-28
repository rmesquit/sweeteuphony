var currentSongCount;  

function updateSource(song){ 
	currentSongCount=song;
	//alert(currentSongCount);
	var player = document.getElementById('player');
    var source = document.getElementById('src1');
	source.src = document.getElementById(song).getAttribute('data-value');
	//alert(source.src);
	player.load();
	player.play();
	playButton.className = "";
	playButton.className = "pause";
	loadID3tags();
	

		
}

$('.table > tbody > tr').click(function() {
    var id=this.id;
	
	if(id!="song-metadata"){
		if(id!="progressbartime"){
			$(this).addClass("active").siblings().removeClass("active");
		}
	}
	
	
});



var activeSong;
//Does a switch of the play/pause with one button.
function playPause(id){
	var playButton = document.getElementById('playButton'); // play button
    //Sets the active song since one of the functions could be play.
    activeSong = document.getElementById('player');
    //Checks to see if the song is paused, if it is, play it from where it left off otherwise pause it.
    if (activeSong.paused){
         activeSong.play();
		playButton.className = "";
			playButton.className = "pause";
    }else{
         activeSong.pause();
		 playButton.className = "";
		playButton.className = "play";
    }
}

//Updates the current time function so it reflects where the user is in the song.
//This function is called whenever the time is updated.  This keeps the visual in sync with the actual time.
function updateTime(){
	activeSong = document.getElementById('player');
    var currentSeconds = (Math.floor(activeSong.currentTime % 60) < 10 ? '0' : '') + Math.floor(activeSong.currentTime % 60);
    var currentMinutes = Math.floor(activeSong.currentTime / 60);
    //Sets the current song location compared to the song duration.
    document.getElementById('currentSongTimeElapsed').innerHTML = currentMinutes + ":" + currentSeconds;
	document.getElementById('currentSongDuration').innerHTML = Math.floor(activeSong.duration / 60) + ":" + (Math.floor(activeSong.duration % 60) < 10 ? '0' : '') + Math.floor(activeSong.duration % 60);
	

    //Fills out the slider with the appropriate position.
    var percentageOfSong = (activeSong.currentTime/activeSong.duration);
	var percentageOfSlider = document.getElementById('songSlider').offsetWidth * percentageOfSong;
    
    //Updates the track progress div.
    document.getElementById('trackProgress').style.width = Math.round(percentageOfSlider) + "px";
	
	if(percentageOfSong==1.0)
	{
		var countTR = 10 * currentSongCount;
		var row = document.getElementById(countTR);
		currentSongCount++;
		updateSource(currentSongCount);
		row.className = "";
		countTR = 10 * currentSongCount;
		row = document.getElementById(countTR);
		row.className = "active";
		
	}
	
	
}


//Sets the location of the song based off of the percentage of the slider clicked.
function setLocation(percentage){
    activeSong.currentTime = activeSong.duration * percentage;
}
/*
Gets the percentage of the click on the slider to set the song position accordingly.
Source for Object event and offset: http://website-engineering.blogspot.com/2011/04/get-x-y-coordinates-relative-to-div-on.html
*/
function setSongPosition(obj,e){
    //Gets the offset from the left so it gets the exact location.
    var songSliderWidth = obj.offsetWidth;
    var evtobj=window.event? event : e;
    clickLocation =  evtobj.layerX - obj.offsetLeft;
    
    var percentage = (clickLocation/songSliderWidth);
    //Sets the song location with the percentage.
    setLocation(percentage);
}



//Stop song by setting the current time to 0 and pausing the song.
function stopSong(){
    activeSong.currentTime = 0;
    activeSong.pause();
	playButton.className = "";
		playButton.className = "play";
}


function forward(){
   var countTR = 10 * currentSongCount;
		var row = document.getElementById(countTR);
		currentSongCount++;
		updateSource(currentSongCount);
		row.className = "";
		countTR = 10 * currentSongCount;
		row = document.getElementById(countTR);
		row.className = "active";
		
		
		
}


		

function backward(){
   var countTR = 10 * currentSongCount;
		var row = document.getElementById(countTR);
		currentSongCount--;
		updateSource(currentSongCount);
		row.className = "";
		countTR = 10 * currentSongCount;
		row = document.getElementById(countTR);
		row.className = "active";
}






