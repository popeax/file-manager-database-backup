<?php
/*
Plugin Name: File Browser, Manager and Backup (+ Database)
Description: View, Edit, Browser , Zip and Unzip files and folders.. Make Backups of files and databases + RESTORE them easily. (STANDALONE PHP VERSI0N IS AVAILABLE TOO). Use at your own risk. (OTHER MUST-HAVE PLUGINS : http://codesphpjs.blogspot.com/2014/10/must-have-wordpress-plugins.html )
Author: selnomeria, must@fa#
Version: 1.21
License: GPLv2 free
*/ if ( ! defined( 'ABSPATH' ) ) exit; //Exit if accessed directly

define('domainURL__FBMB',				(((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS']!=='off') || $_SERVER['SERVER_PORT']==443) ? 'https://':'http://' ).$_SERVER['HTTP_HOST']);
define('homeURL__FBMB',					home_url());
define('homeFOLD__FBMB',				str_replace(domainURL__FBMB,'',	homeURL__FBMB));
define('requestURI__FBMB',				$_SERVER["REQUEST_URI"]); 				define('requestURIfromHome__FBMB', str_replace(homeFOLD__FBMB, '',requestURI__FBMB) ); 	define('requestURIfromHomeWithoutParameters__FBMB',parse_url(requestURIfromHome__FBMB, PHP_URL_PATH));
define('currentURL__FBMB',				domainURL__FBMB.requestURI__FBMB);
define('THEME_URL_nodomain__FBMB',		str_replace(domainURL__FBMB, '', get_template_directory_uri()) );
define('PLUGIN_URL_nodomain__FBMB',		str_replace(domainURL__FBMB, '', plugin_dir_url(__FILE__)) );
define('THEME_DIR__FBMB',				get_stylesheet_directory() );
define('PLUGIN_DIR__FBMB',				plugin_dir_path(__FILE__) );




define('plugin_pageslug__FBMB',		'wfmb-pagee');		
//==================================================== ACTIVATION commands ===============================		
//redirect after activation
add_action( 'activated_plugin', 'activat_redirect__WFMB' ); function activat_redirect__WFMB( $plugin ) { 
    if( $plugin == plugin_basename( __FILE__ ) ) { exit(wp_redirect( admin_url( 'admin.php?page='.plugin_pageslug__FBMB.'&firsttime')) );  }
}		
//ACTIVATION HOOK
register_activation_hook( __FILE__, 'activation__WFMB' );function activation__WFMB() { 
	//UpgrateHtaccess__WFMB();
}
register_deactivation_hook( __FILE__, 'deactivation__WFMB' );function deactivation__WFMB() { 
	//DowngrateHtaccess__WFMB();
}	
// =========================== CREATE HTACCESS=======================
function UpgrateHtaccess__WFMB(){	$htfile=ABSPATH.'.htaccess';
	$new_htacont="\r\n\r\n#start_wfmb_url\r\n<IfModule mod_php5.c>".
	"\r\nredirect 302 /filemanager ".wfmb_filenamLink.
	"\r\n</IfModule>\r\n#end_wfmb_url"."\r\n\r\n";
	//If HTACCESS doesnt exist
	if (!file_exists($htfile))	{file_put_contents($htfile, $new_htacont);}
	//if HTACCESS exists, but not written the spec.lines
	else {
		$Htacont=file_get_contents($htfile);
		//if existed htaccess, but not written the spec.lines
		if (stripos($Htacont,'#start_wfmb_url')===false){file_put_contents($htfile, $Htacont. $new_htacont);}
	}
}
function DowngrateHtaccess__WFMB(){
	$htfile=ABSPATH.'.htaccess';
	if (file_exists($htfile))	{$ht_cont = file_get_contents($htfile);
		$new_ht_cont = preg_replace('/\#start_wfmb_url(.*?)\#end_wfmb_url/si','',$ht_cont);
		file_put_contents($htfile,$new_ht_cont);
	}
}
// =========================== END##CREATE HTACCESS=======================




//======================================== check for plugin updates =======================
define('PluginName__FBMB', 'File_Manager___Database_Backuper'); define('PluginUrl__FBMB','http://plugins.svn.wordpress.org/file-manager-database-backup/trunk/index.php'); define('PluginDown__FBMB','https://wordpress.org/plugins/file-manager-database-backup/changelog/');
//add_action('admin_notices', 'check_updates__FBMB'); 
function check_updates__FBMB(){	if (current_user_can('create_users')){
		$OPTNAME_checktimee=PluginName__FBMB.'_updatechecktime';	$last_checktime=get_option($OPTNAME_checktimee,false);
		if (!$last_checktime || $last_checktime<time()-5*86400){  $VPattern='/plugin name(.*?)version\:(.*?)(\r\n|\r|\n)/si';
			preg_match($VPattern,file_get_contents(__FILE__),$A); preg_match($VPattern,get_remote_data__FBMB(PluginUrl__FBMB),$B);
			if (trim($B[2]) && trim($B[2])!=trim($A[2])){ update_option($OPTNAME_checktimee,time());
				echo '<div style="position: fixed; width: 100%; padding: 10px; background-color: #FFC0CB; z-index: 7777; border: 15px solid;">'.PluginName__FBMB.' has updated version('.$B[2].') already! Please, read <a href="'.PluginDown__FBMB.'" target="_blank">CHANGELOGS</a> page and update on your site too</a>!</div>';	return true;
}}}}
	//=================== compressed version===============https://github.com/tazotodua/useful-php-scripts/==========================
	function get_remote_data__FBMB($url, $post_paramtrs=false)	{
	   $c = curl_init();curl_setopt($c, CURLOPT_URL, $url);curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);	if($post_paramtrs){curl_setopt($c, CURLOPT_POST,TRUE);	curl_setopt($c, CURLOPT_POSTFIELDS, "var1=bla&".$post_paramtrs );}	curl_setopt($c, CURLOPT_SSL_VERIFYHOST,false);curl_setopt($c, CURLOPT_SSL_VERIFYPEER,false);curl_setopt($c, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; rv:33.0) Gecko/20100101 Firefox/33.0"); curl_setopt($c, CURLOPT_COOKIE, 'CookieName1=Value;');	curl_setopt($c, CURLOPT_MAXREDIRS, 10);  $follow_allowed= ( ini_get('open_basedir') || ini_get('safe_mode')) ? false:true;  if ($follow_allowed){curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);}curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 9);curl_setopt($c, CURLOPT_REFERER, $url);curl_setopt($c, CURLOPT_TIMEOUT, 60);curl_setopt($c, CURLOPT_AUTOREFERER, true);  		curl_setopt($c, CURLOPT_ENCODING, 'gzip,deflate');$data=curl_exec($c);$status=curl_getinfo($c);curl_close($c);preg_match('/(http(|s)):\/\/(.*?)\/(.*\/|)/si',  $status['url'],$link);$data=preg_replace('/(src|href|action)=(\'|\")((?!(http|https|javascript:|\/\/|\/)).*?)(\'|\")/si','$1=$2'.$link[0].'$3$4$5', $data);$data=preg_replace('/(src|href|action)=(\'|\")((?!(http|https|javascript:|\/\/)).*?)(\'|\")/si','$1=$2'.$link[1].'://'.$link[3].'$3$4$5', $data);if($status['http_code']==200) {return $data;} elseif($status['http_code']==301 || $status['http_code']==302) { if (!$follow_allowed){if(empty($redirURL)){if(!empty($status['redirect_url'])){$redirURL=$status['redirect_url'];}}	if(empty($redirURL)){preg_match('/(Location:|URI:)(.*?)(\r|\n)/si', $data, $m);if (!empty($m[2])){ $redirURL=$m[2]; } }	if(empty($redirURL)){preg_match('/href\=\"(.*?)\"(.*?)here\<\/a\>/si',$data,$m); if (!empty($m[1])){ $redirURL=$m[1]; } }	if(!empty($redirURL)){$t=debug_backtrace(); return call_user_func( $t[0]["function"], trim($redirURL), $post_paramtrs);}}} return "ERRORCODE22 with $url!!<br/>Last status codes<b/>:".json_encode($status)."<br/><br/>Last data got<br/>:$data";
	}


//add_action('admin_menu', 'wfmb_external_link_admin_submenu');function wfmb_external_link_admin_submenu() {global $menu;$menu[] = array( 'filemanager', 'manage_options', plugin_dir_url(__file__).'/filemanager.php','dashicons-media-spreadsheet','dashicons-media-spreadsheet' );}	

define('wfmb_real_root',	 str_replace('\\',DIRECTORY_SEPARATOR, str_replace('/',DIRECTORY_SEPARATOR, $_SERVER['DOCUMENT_ROOT']))    );
define('wfmb_real_abspath', str_replace('\\',DIRECTORY_SEPARATOR, str_replace('/',DIRECTORY_SEPARATOR, ABSPATH))    );
	$wp_dir = str_replace( wfmb_real_root,'', wfmb_real_abspath);
define('wfmb_tempnumb',		rand(1,11111).rand(1,11111) );	
define('wfmb_startpath',	'/'.basename(ABSPATH) );
define('wfmb_filenamLink',	plugin_dir_url(__file__).'filemanager.php?path=.'.urlencode(wfmb_startpath).'&wpdir='.urlencode($wp_dir));
	
//simple redirection
add_action('init','redirect__WFMB');function redirect__WFMB(){ 
	if (substr($_SERVER['REQUEST_URI'],-12) == '?filemanager'){  header("location:".wfmb_filenamLink);exit; }
}


add_action('admin_footer','wfmb_addsubmenulinktarget');function wfmb_addsubmenulinktarget(){
	echo '<script type="text/javascript">var wfmb_link= document.getElementById("toplevel_page_'.plugin_pageslug__FBMB.'").getElementsByClassName("menu-top")[0]; if (wfmb_link){wfmb_link.setAttribute("target","_blank");wfmb_link.setAttribute("href","'.wfmb_filenamLink.'");}</script>';
}
	
add_action('admin_menu', 'wfmb_regist'); function wfmb_regist() {add_menu_page('File Manager', 'File Manager', 'administrator', plugin_pageslug__FBMB, 'wfmb_output_func','dashicons-media-spreadsheet'); } function wfmb_output_func(){
	?>
	<?php
		if (isset($_GET['firsttime'])) { ?> <script type="text/javascript">alert("You can enter FILE MANAGER page from the left sidebar menu"); </script> <?php } 
		elseif (!check_updates__FBMB()) { ?><script type="text/javascript"> window.location = "<?php echo wfmb_filenamLink;?>";	</script>	<?php } 
	?>
		<!--
		<style>	.br_window_div{width: 100%;height:100%;} iframe.fr_window{width: 100%;height:100%;} .version_message {background-color: #F00;float: left;padding: 10px;margin: 10px;font-size: 2em;}	</style>
		
		<div class="br_window_div">
			<iframe onLoad="autoResize('ifrm1');" id="ifrm1" src="<?php echo wfmb_filenamLink; ?>"  class="fr_window" scrolling="none"  frameborder="0"></iframe>
		</div>
		
		<script language="JavaScript">
		function autoResize(id)		{
			var newheight;
			if( document.getElementById(id) ){ newheight=document.getElementById(id).contentWindow.document.body.scrollHeight; }
			if (newheight < 400) {newheight = 400;}
			document.getElementById(id).style.height= parseInt(newheight+40) + "px";
		}
		</script>
		-->
	
	<?php
}
?>