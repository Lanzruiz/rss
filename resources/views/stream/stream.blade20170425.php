<html>
<head>
    <!-- flowplayer javascript component -->
    <script src="http://releases.flowplayer.org/js/flowplayer-3.2.13.min.js"></script>
</head>
 
<body>
<div id="player" style="width:644px;height:276px;margin:0 auto;text-align:center">
 </div>





<script>
 
$f("player", "http://releases.flowplayer.org/swf/flowplayer-3.2.16.swf", {
    clip: {       
        url: 'sample.mp4', 
        scaling: 'fit',
        live: true,
        autoPlay: true,
        provider: 'hddn'
    },

 
    plugins: {
        hddn: {
            url: "http://54.214.201.246/api/public/assets/flowplayer.rtmp-3.2.13.swf",
 
            // netConnectionUrl defines where the streams are found
            //netConnectionUrl: 'rtmp://54.214.201.246:1935/vod2/sample4.mp4'
            netConnectionUrl: 'rtmp://54.214.201.246/live'
        }
    },
    canvas: {
        backgroundGradient: 'none'
    }
});
$f("player").play();
</script>
</body>
</html>