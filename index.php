<?php
/*
Plugin Name: File Browser, Manager and Backuper (+ Database)
Description: View, Edit, Browser , Zip and Unzip files and folders.. Make Backups of files and databases + RESTORE them easily. (STANDALONE PHP VERSI0N is here: https://github.com/tazotodua/Simple-PHP-file-browser-manager/ )
Author: selnomeria, must@fa#
Version: 1.1
License: GPLv2
*/

//Wordpress File Manager & Browser


add_action('admin_menu', 'wfmb_regist'); function wfmb_regist() {add_menu_page('File Manager and Backuper', 'File Manager and Backuper', 'administrator','wfmb-page', 'wfmb_output_func'); }
function wfmb_output_func()
{


	$start_path = '/'.basename(dirname(dirname(dirname(dirname(__FILE__)))));
	$tmp_filee	= substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, '7') .'pmp';

	?>
	
	
	<style>
	.br_window_div	{	width: 100%;	height:100%;	}
	iframe.fr_window{	width: 100%;	height:100%;	}
	</style>

	<div class="br_window_div">
		<iframe onLoad="autoResize('ifrm1');" id="ifrm1" src="<?php echo plugins_url('',__FILE__); ?>/filemanager.php?do=login&path=.<?php echo $start_path;?>&temp_pass_file=<?php echo $tmp_filee;?>"  class="fr_window" scrolling="none"  frameborder="0"></iframe>
	</div>
	
	<script language="JavaScript">
	function autoResize(id)
	{
		var newheight;
		if( document.getElementById(id) ){
			newheight=document.getElementById(id).contentWindow.document.body.scrollHeight;
		}
		if (newheight < 400) {newheight = 400;}
		document.getElementById(id).style.height= parseInt(newheight+40) + "px";
	}
	</script>



	<?php
}
?>