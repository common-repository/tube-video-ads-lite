<?php if($mode == "1"  ) : ?>
<script type='text/javascript' >
    jQuery(document).ready(function($){

        var $element = $("#<?php _e($id); ?>");

        $element.find(".tva-button").hover(function(){
            $element.addClass("tva-hover");
        },function(){
            $element.removeClass("tva-hover");
        });
    });
</script>
<div id='tva' >
    <div id='<?php _e($id); ?>' class='tva-wrapper tva-type-button' >
        <div class='tva-inner-wrapper'>       
            <div class='tva-content' ></div>
            <a class='tva-button' href="<?php _e(esc_attr($adurl)); ?>" ><?php _e($button_text); ?></a> 
        </div>
        <div id='<?php _e($id); ?>_player'></div>
    </div>
</div>
<?php else : ?>
<div id='tva' >
    <div id='<?php _e($id); ?>' class='tva-wrapper tva-type-banner' >
        <div class='tva-inner-wrapper'>
            <a class='tva-banner' href="<?php _e(esc_attr($adurl)); ?>" ><img src='<?php _e(esc_attr($bannerurl)); ?>' alt='' title='' /></a> 
        </div>
        <div id='<?php _e($id); ?>_player'></div>
    </div>
</div>
<?php endif; ?>
<script>
    if( window.youtubeAPIInit !== true ) {
        window.youtubeAPIInit = true;
        var tag = document.createElement('script');
        tag.src = "https://www.youtube.com/player_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
        window.youtubeAPIReady = false;
        window.videos = new Object();
        window.videos['<?php _e($id); ?>'] = { 
            videoID : '<?php  _e($youtube_video); ?>',
            playerID : '<?php _e($id); ?>_player'
        };

        function onYouTubePlayerAPIReady() {
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

            jQuery.each(window.videos,function(i,video){
                window.initializePlayer( video );
            });
        }
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
</script>