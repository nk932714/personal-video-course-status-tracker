<?php
if (isset($_GET['link'])) { $link = $_GET["link"]; 	}     else { die("something is missing");   }
if (isset($_GET['id'])) { $id = $_GET["id"];	    }       else { die("something is missing");   }
if (isset($_GET['text'])) { $text = $_GET["text"]; 	}     else { die("something is missing");   }
?>

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <Style>
            #status span.status {
            display: none;
            font-weight: bold;
            }
            span.status.complete {
                color: green;
                            }
            span.status.incomplete {
                                color: red;
                                }
            #status.complete span.status.complete {
                                display: inline;
                                                    }
            #status.incomplete span.status.incomplete {
                                display: inline;
                                                    }
    </Style>
    
</head>
<video width="480" height="400" controls="true" poster="" id="video">
    <source type="video/mp4" src="<?php echo $link.'&id='.$id; ?>"></source>
</video>

<div id="status" class="incomplete">
<span>Play status: </span>
<span class="status complete">COMPLETE</span>
<span class="status incomplete">INCOMPLETE</span>
<br />
</div>
<div>
<span id="played">0</span> seconds out of 
<span id="duration"></span> seconds. (only updates when the video pauses)
</div>


<script>
        var video = document.getElementById("video");
        var timeStarted = -1;
        var timePlayed = 0;
        var duration = 0;
        // If video metadata is laoded get duration
        if(video.readyState > 0)
        getDuration.call(video);
        //If metadata not loaded, use event to get it
        else
        {
            video.addEventListener('loadedmetadata', getDuration);
            
        }
        // remember time user started the video
        function videoStartedPlaying() {
            timeStarted = new Date().getTime()/1000;
        }
        function videoStoppedPlaying(event) {
            // Start time less then zero means stop event was fired vidout start event
            if(timeStarted>0) {
                var playedFor = new Date().getTime()/1000 - timeStarted;
                timeStarted = -1;
                // add the new ammount of seconds played
                timePlayed+=playedFor;
        }
        document.getElementById("played").innerHTML = Math.round(timePlayed)+"";
        // Count as complete only if end of video was reached
        if(timePlayed>=duration && event.type=="ended") {
            document.getElementById("status").className="complete";
            $.get("load_page.php?key=<?php echo $text; ?>");
            }
            
        }
        
        function getDuration() {
            duration = video.duration;
            document.getElementById("duration").appendChild(new Text(Math.round(duration)+""));
            console.log("Duration: ", duration);
        }
            video.addEventListener("play", videoStartedPlaying);
            video.addEventListener("playing", videoStartedPlaying);
            video.addEventListener("ended", videoStoppedPlaying);
            video.addEventListener("pause", videoStoppedPlaying);
</script>
