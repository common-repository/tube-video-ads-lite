(function(){
var style_el = document.getElementById("tva-front-style");
if( !style_el ){
	style_el = document.createElement("link");
	style_el.type = "text/css";
    style_el.rel = "stylesheet";
    style_el.href = "<?php _e($style_url); ?>";	
    style_el.id = "tva-front-style";
	document.getElementsByTagName("head")[0].appendChild(style_el);
}
<?php if($mode=="2") :?>
document.write(
"<div id='tva' ><div id='<?php _e($id); ?>' class='tva-wrapper tva-type-banner' >"+
    "<div class='tva-inner-wrapper'>"+
        "<a class='tva-banner' href='<?php _e(esc_attr($adurl)); ?>' ><img src='<?php _e(esc_attr($bannerurl)); ?>' alt='' title='' /></a>"+
    "</div>"+
    "<div id='<?php _e($id); ?>_player'></div>"+
"</div></div>"
);
<?php else : ?>
document.write(
"<div id='tva' ><div id='<?php _e($id); ?>' class='tva-wrapper tva-type-button' >"+
    "<div class='tva-inner-wrapper'>"+       
        "<div class='tva-content' ></div>"+
        "<a class='tva-button' href='<?php _e(esc_attr($adurl)); ?>' ><?php _e(htmlentities($button_text)); ?></a> "+
    "</div>"+
    "<div id='<?php _e($id); ?>_player'></div>"+
"</div></div>");
var wrapper = document.getElementById("<?php _e($id); ?>"),
	button = wrapper.getElementsByTagName("a")[0];

button.onmouseover = function(){
	wrapper.className = wrapper.className+" tva-hover";
};

button.onmouseout = function(){
	wrapper.className = wrapper.className.replace("tva-hover","");
};   

<?php endif; ?>
if( window.youtubeAPIInit !== true ) {
    window.youtubeAPIInit = true;
    window.youtubeAPIReady = false;
    window.videos = new Object();
    window.videos['<?php _e($id); ?>'] = { 
        videoID : '<?php  _e($youtube_video); ?>',
        playerID : '<?php _e($id); ?>_player'
    };
    window.onYouTubePlayerAPIReady = function() {
        window.youtubeAPIReady = true;
        window.initializePlayer =function( video ){
            var player = new YT.Player(video.playerID, {
              height: '390',
              width: '640',
              videoId: video.videoID,
              playerVars: {
                  wmode: "transparent"
              }
         });
        }
        for( var i in window.videos ){
            window.initializePlayer(  window.videos[i] );
        };
    }
    var tag = document.createElement('script');
    tag.src = "https://www.youtube.com/player_api";
    document.getElementsByTagName("head")[0].appendChild(tag);
}
else {
    if( window.youtubeAPIReady !== true ){ 
       window.videos['<?php _e($id); ?>'] = { 
            videoID : '<?php  _e($youtube_video); ?>',
            playerID : '<?php _e($id); ?>_player'
        };
    }
    else {
        window.initializePlayer( { 
            videoID : '<?php  _e($youtube_video); ?>',
            playerID : '<?php _e($id); ?>_player'
        } );
    }
}
})();