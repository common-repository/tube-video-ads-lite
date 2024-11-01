<script>
    jQuery(document).ready(function($) {

		 var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
            formArray = jQuery('#post').serializeArray();
            var data = {
                                
            };
            
            jQuery.each(formArray, function(i, field){
                data[field.name] = field.value;
            });
            
			data['action'] = 'preview_video';
            
            jQuery.post(ajaxurl, data, function(response) {
                jQuery('#video_zone').html(response);
            });
	
        jQuery('#updatepreview').on('click', function() {
            var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
            formArray = jQuery('#post').serializeArray();
            var data = {
                                
            };
            
            jQuery.each(formArray, function(i, field){
                data[field.name] = field.value;
            });
            
			data['action'] = 'preview_video';
            
            jQuery.post(ajaxurl, data, function(response) {
                jQuery('#video_zone').html(response);
            });
        })

        $("select[name='mode']").change(function(){

        	if( $(this).val() == "1"){
        		$("#tva-form").removeClass("tva-mode-banner").addClass("tva-mode-button");
        	}
        	else {
        		$("#tva-form").removeClass("tva-mode-button").addClass("tva-mode-banner");
        	}
        }).trigger("change");
	})
</script>

<h2><?php echo $title; ?> </h2>
<style>
.inside li{
	text-align: right;
}

.inside li input, .inside li select{
	width:200px;
}

#title{
	width:1000px;
	margin: 10px;
}

.postbox{
	width:1000px;
}

.postbox h3{
	margin-left:10px;
}

#save{
	float:right;
}

#updatepreview{
	float:right;
}

#postbox-container-1{
	display:none;
}
#post-preview{
display:none;
}

.tva-mode-button .mode-banner {
	display:none;
}

.tva-mode-banner .mode-button {
	display:none;
}

#tva-form {
	overflow:hidden;
}

#tva-go-pro {
	border:1px solid red;
	margin-bottom:13px;
}

#tva-go-pro:hover {
	border-color:#990000;
}

#tva-go-pro-link {
	display:block;
	text-align:center;
	color:white;
	font-size:14px;
	font-weight:bold;
	background:red;
	padding:5px;
	text-decoration:none;
}

#tva-go-pro:hover #tva-go-pro-link{
	background:#990000;
}

</style>
	
<div class="inside <?php echo $mode=='1' ? 'tva-mode-button' : 'tva-mode-banner'; ?>"  id='tva-form'>
	<div style="float:left">
		<ul>
			<li> <label>YouTube Video </label> <input id="youtubevideo" type="text" name="youtubevideo" value="<?php echo $youtube_video ?>" /> </li>
			<li> 
				<label>Ad Mode </label> 
				<select name="mode" >
					<option <?php if($mode==1)  echo 'selected';?> value="1">Button</option>
					<option <?php if($mode==2)  echo 'selected';?> value="2">Banner</option>
				</select>
			</li>
			<li class='mode-banner'> 
				<label>Banner URL </label> 
				<input id="bannerurl" type="text" name="bannerurl" value="<?php echo $bannerurl; ?>"/> 
			</li>
			<li> 
				<label>Ad URL </label> 
				<input id="adurl" type="text" name="adurl" value="<?php echo $adurl; ?>"/> 
			</li>
			<li class='mode-button'> 
				<label>Ad Text </label> 
				<input id="button_text" type="text" name="button_text" value="<?php echo $button_text; ?>"/> 
			</li>
		</ul>
		<div id='tva-go-pro' >
			<a href='http://www.tubevideoads.com/' id='tva-go-pro-link' taget='_blank' >CLICK HERE TO UNLOCK THESE FEATURES</a>
			<ul>
				<li> 
					<label>Ad Position </label> 
					<select name="position">
						<option value="1">Top Left</option>
						<option value="2">Top Right</option>
						<option value="3">Top Center</option>
						<option value="4">Bottom Left</option>
						<option value="5">Bottom Right</option>
						<option value="6">Bottom Center</option>
					</select>
				</li>
				<li> 
					<label>Delay </label>     
					<input id="delay" type="number" name="delay" value="0"/> 
				</li>
				<li> <label>Hover Title </label> <input id="hovertitle" type="text" name="hovertitle" value="2014 World Cup"/> </li>
				<li> <label>Hover Text </label> <input id="hoverurl" type="text" name="hovertext" value="Fly To Brazil"/> </li>
			</ul>
		</div>
		<input type="button" class='button' value="Preview" name="updatepreview" id="updatepreview"  />		
		<?php post_submit_meta_box($post) ?>
		
	</div>
	<div id="video_zone" style="float:right;"></div>
</div>