<?php
function site_assets_footer(){
	global $post;
	
	$sap =  get_option('site_assets_position');
	$sas =  get_option('site_assets_style') ? 'site_assets_style_'.get_option('site_assets_style') : 'site_assets_style_default';

	if($sas=="site_assets_style_custom"){
		$sas_custom_border_size =  get_option('site_assets_style_custom_border_size');
	    $sas_custom_border_color =  get_option('site_assets_style_custom_border_color');
	    $sas_custom_title_color =  get_option('site_assets_style_custom_title_color');
	    $sas_custom_link_color =  get_option('site_assets_style_custom_link_color');
	    $sas_custom_hover_color =  get_option('site_assets_style_custom_hover_color');
	    echo '
	    <style>
	    #site_assets.site_assets_style_custom{
	        border: '.$sas_custom_border_size.' solid '.$sas_custom_border_color.' !important;
	        background-color:#2E4172 !important;
	    }
	     #site_assets.site_assets_style_custom #site_assets_title{
	        color: '.$sas_custom_title_color.' !important;
	    }
	    #site_assets.site_assets_style_custom a, #site_assets.site_assets_style_custom a:visited, #site_assets.site_assets_style_custom a:active{
	        color: '.$sas_custom_link_color.' !important;
	    }
	    #site_assets.site_assets_style_custom a:hover{
	        color: '.$sas_custom_hover_color.' !important;
	    }
	    </style>
	    ';
	}

	$sa_urls = get_post_meta( $post->ID, '_site_assets_urls', true );
	$sa_urls = json_decode($sa_urls);
	
	if(count($sa_urls) == 0){
		return FALSE;
	}

	$r = '<div id="site_assets" class="site_assets '.$sas.' site_assets_'.$sap.'">';
	$r.='<div class="site_assets_title" id="site_assets_title">Site Assets</div>';

	foreach($sa_urls AS $u){
		$p = explode("|",$u);
		if(count($p)>1){
			$r.='<div class="site_asset"><a href="'.$p[0].'" target="_blank">'.$p[1].'</a></div>'."\r\n";
		}
		else{
			$r.='<div class="site_asset"><a href="'.$p[0].'" target="_blank">'.$p[0].'</a></div>'."\r\n";	
		}
	}
	$r.='</div>';	
	echo $r;	
}
add_action('wp_print_footer_scripts', 'site_assets_footer');
