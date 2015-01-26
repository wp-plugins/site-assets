<?php 
	if($_POST) {
        $site_assets_manage = json_encode($_POST['site_assets_manage']);
        $site_assets_view = json_encode($_POST['site_assets_view']);
        $site_assets_position = sanitize_text_field($_POST['site_assets_position']);
        $site_assets_style = sanitize_text_field($_POST['site_assets_style']);

		update_option('site_assets_manage', $site_assets_manage);
        update_option('site_assets_view', $site_assets_view);
        update_option('site_assets_position', $site_assets_position);
        update_option('site_assets_style', $site_assets_style);

        if($site_assets_style=="custom"){
            $site_assets_style_custom_border_size = $_POST['site_assets_style_custom_border_size'];
            $site_assets_style_custom_border_color = $_POST['site_assets_style_custom_border_color'];
            $site_assets_style_custom_title_color = $_POST['site_assets_style_custom_title_color'];
            $site_assets_style_custom_link_color = $_POST['site_assets_style_custom_link_color'];
            $site_assets_style_custom_hover_color = $_POST['site_assets_style_custom_hover_color'];

            update_option('site_assets_style_custom_border_size', $site_assets_style_custom_border_size);
            update_option('site_assets_style_custom_border_color', $site_assets_style_custom_border_color);
            update_option('site_assets_style_custom_title_color', $site_assets_style_custom_title_color);
            update_option('site_assets_style_custom_link_color', $site_assets_style_custom_link_color);
            update_option('site_assets_style_custom_hover_color', $site_assets_style_custom_hover_color);
        }

        ?>
        <div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>
        <?php
	}

    $site_assets_manage =  json_decode(get_option('site_assets_manage'));
    $site_assets_view =  json_decode(get_option('site_assets_view'));
    $sap =  get_option('site_assets_position');
    $sas =  get_option('site_assets_style');


    $site_assets_style_custom_border_size =  get_option('site_assets_style_custom_border_size');
    $site_assets_style_custom_border_color =  get_option('site_assets_style_custom_border_color');
    $site_assets_style_custom_title_color =  get_option('site_assets_style_custom_title_color');    
    $site_assets_style_custom_link_color =  get_option('site_assets_style_custom_link_color');
    $site_assets_style_custom_hover_color =  get_option('site_assets_style_custom_hover_color');
?>


<div id="site_assets" class="wrap">
	<?php echo "<h2>" . __( 'Site Assets Settings', 'site_assets' ) . "</h2>"; ?>
    
    <h3>Select Site Assets Permissions</h3>
    <form name="site_data_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
        <div class="sa_block">
            <div class="sa_title">Add / Manage Assets</div>
            <?php foreach (get_editable_roles() as $role): ?>
                <div class="sa_role">
                    <input type="checkbox" <?php if(in_array($role['name'], $site_assets_manage)){echo ' checked';} ?> name="site_assets_manage[]" id="sa_manage_<?php echo $role['name']; ?>" value="<?php echo $role['name']; ?>" /> <label for="sa_manage_<?php echo $role['name']; ?>"><?php echo $role['name']; ?></label>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="sa_block">
            <div class="sa_title">View Assets</div>
            <?php foreach (get_editable_roles() as $role): ?>
                <div class="sa_role">
                    <input type="checkbox" <?php if(in_array($role['name'], $site_assets_view)){echo ' checked';} ?>  name="site_assets_view[]" id="sa_view_<?php echo $role['name']; ?>" value="<?php echo $role['name']; ?>" /> <label for="sa_view_<?php echo $role['name']; ?>"><?php echo $role['name']; ?></label>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="sa_block_style">
            <div class="sa_title">Front End Style</div>
            <input id="ptl" type="radio" name="site_assets_position" value="top_left" <?php if($sap=="top_left" OR $sap==""){echo ' checked';} ?> /> <label for="ptl">Top Left (default)</label> <br />
            <input id="ptr" type="radio" name="site_assets_position" value="top_right" <?php if($sap=="top_right"){echo ' checked';} ?> /> <label for="ptr">Top Right</label> <br />
            <input id="pbl" type="radio" name="site_assets_position" value="bottom_left" <?php if($sap=="bottom_left"){echo ' checked';} ?> /> <label for="pbl">Bottom Left</label> <br />
            <input id="pbr" type="radio" name="site_assets_position" value="bottom_right" <?php if($sap=="bottom_right"){echo ' checked';} ?> /> <label for="pbr">Bottom Right</label><br /><br/>
            <label for="site_assets_style">Style</label> <select id="site_assets_style" name="site_assets_style">
                <option value="" <?php if($sas==""){echo ' selected';} ?>>Default</option>
                <option value="theme" <?php if($sas=="theme"){echo ' selected';} ?>>Theme</option>
                <option value="light" <?php if($sas=="light"){echo ' selected';} ?>>Light</option>
                <option value="dark" <?php if($sas=="dark"){echo ' selected';} ?>>Dark</option>
                <option value="custom" <?php if($sas=="custom"){echo ' selected';} ?>>Custom</option>
            </select>
            <div id="site_assets_custom_block" <?php if($site_assets_style!="custom"){echo 'style="display:none"';}?>>
                <div class="site_custom_group">Box Style</div>
                Box Border Size: 
                    <select name="site_assets_style_custom_border_size" id="site_assets_style_custom_border_size">
                        <option value="0"<? if($site_assets_style_custom_border_size==0){echo ' selected';}?>>None</option>
                        <option value="1px"<? if($site_assets_style_custom_border_size=='1px'){echo ' selected';}?>>1px</option>
                        <option value="2px"<? if($site_assets_style_custom_border_size=='2px'){echo ' selected';}?>>2px</option>
                        <option value="3px"<? if($site_assets_style_custom_border_size=='3px'){echo ' selected';}?>>3px</option>
                        <option value="4px"<? if($site_assets_style_custom_border_size=='4px'){echo ' selected';}?>>4px</option>
                        <option value="5px"<? if($site_assets_style_custom_border_size=='5px'){echo ' selected';}?>>5px</option>
                    </select><br />
                Box Border Color: 
                    <input type="text" name="site_assets_style_custom_border_color" id="site_assets_style_custom_border_color" placeholder="#FFFFFF" value="<?=$site_assets_style_custom_border_color;?>" /><br />
                <div class="site_custom_group">Box Links</div>
                Box Title: 
                    <input type="text" name="site_assets_style_custom_title_color" id="site_assets_style_custom_title_color" placeholder="#000000" value="<?=$site_assets_style_custom_title_color;?>" /><br />
                Box Link: 
                    <input type="text" name="site_assets_style_custom_link_color" id="site_assets_style_custom_link_color" placeholder="#000000" value="<?=$site_assets_style_custom_link_color;?>" /><br />
                Box Link Hover: 
                    <input type="text" name="site_assets_style_custom_hover_color" id="site_assets_style_custom_hover_color" placeholder="#CCCCCC" value="<?=$site_assets_style_custom_hover_color;?>" />
            </div>
        </div>
        <div class="submit">
            <input type="submit" name="Submit" value="<?php _e('Update Options', 'site_data_mb' ) ?>" />
        </div>        
    </form>


         <div class="sa_block">
            <div class="sa_title">
                <a href="#" id="show_links">I need a place to upload files</a>
                <a href="#" id="hide_links" style="display:none">Hide this list</a>
            </div>
            <ul id="links" style="display:none">
                <li><a href="http://4shared.com" target="_blank">4Shared</a></li>
                <li><a href="http://box.net" target="_blank">Box.net</a></li>
                <li><a href="http://copy.com" target="_blank">Copy</a></li>
                <li><a href="http://dropbox.com" target="_blank">DropBox</a></li>
                <li><a href="http://egnyte.com" target="_blank">Egnyte</a></li>
                <li><a href="http://filecamp.com" target="_blank">FileCamp</a></li>
                <li><a href="http://firedrive.com" target="_blank">FireDrive</a></li>
                <li><a href="https://drive.google.com" target="_blank">Google Drive</a></li>
                <li><a href="http://hightail.com" target="_blank">Hightail</a></li>
                <li><a href="http://huddle.com" target="_blank">Huddle</a></li>
                <li><a href="http://onedrive.com" target="_blank">OneDrive</a></li>
                <li><a href="http://owncloud.com" target="_blank">ownCloud</a></li>
                <li><a href="http://sharefile.com" target="_blank">ShareFile</a></li>
                <li><a href="http://soonr.com" target="_blank">Soonr</a></li>
                <li><a href="http://spideroak.com" target="_blank">SpiderOak</a></li>
                <li><a href="http://sugarsync.com" target="_blank">SugarSync</a></li>
            </ul>
        </div>


</div>

<script type="text/javascript">
if(jQuery){
    jQuery(document).ready(function($){
        $('#site_assets_style').change(function(){
            if($(this).val() == 'custom'){
                $("#site_assets_custom_block").show();
            }
            else{
                $("#site_assets_custom_block").hide();    
            }
        });
        $("#show_links").click(function(e){
            e.preventDefault();
            $("#links").slideDown();
            $("#show_links").hide();
            $("#hide_links").show();
        })
        $("#hide_links").click(function(e){
            e.preventDefault();
            $("#links").slideUp();
            $("#show_links").show();
            $("#hide_links").hide();
        })
    });
}
</script>