<?php
/*
Plugin Name: Jquery accordion slideshow
Plugin URI: http://www.gopiplus.com/work/2011/12/21/jquery-accordion-slideshow-wordpress-plugin/
Description: This is another slideshow plugin for Word Press with accordion effect using famous JQuery JavaScript. Using this word press plugin we can easily create horizontal accordion slideshow. 
Author: Gopi Ramasamy
Version: 6.6
Author URI: http://www.gopiplus.com/work/2011/12/21/jquery-accordion-slideshow-wordpress-plugin/
Donate link: http://www.gopiplus.com/work/2011/12/21/jquery-accordion-slideshow-wordpress-plugin/
Tags: jquery, accordion, slideshow, accordion slider
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }

global $wpdb, $wp_version;
define("WpJqueryAccordionSlidshowTbl", $wpdb->prefix . "jas_plugin");
define('Wp_JaS_FAV', 'http://www.gopiplus.com/work/2011/12/21/jquery-accordion-slideshow-wordpress-plugin/');

if ( ! defined( 'WP_JaS_BASENAME' ) )
	define( 'WP_JaS_BASENAME', plugin_basename( __FILE__ ) );
	
if ( ! defined( 'WP_JaS_PLUGIN_NAME' ) )
	define( 'WP_JaS_PLUGIN_NAME', trim( dirname( WP_JaS_BASENAME ), '/' ) );
	
if ( ! defined( 'WP_JaS_PLUGIN_URL' ) )
	define( 'WP_JaS_PLUGIN_URL', WP_PLUGIN_URL . '/' . WP_JaS_PLUGIN_NAME );
	
if ( ! defined( 'WP_JaS_ADMIN_URL' ) )
	define( 'WP_JaS_ADMIN_URL', get_option('siteurl') . '/wp-admin/options-general.php?page=jquery-accordion-slideshow' );

function JaSShow() 
{
	global $wpdb;
	$sSql = "select * from ".WpJqueryAccordionSlidshowTbl." where JaS_Gallery = 'GALLERY1'";
	$sSql = $sSql . " order by rand() limit 0,1;";
	$data = $wpdb->get_results($sSql);
	if ( ! empty($data) ) 
	{
		$li = "";
		foreach ( $data as $data ) 
		{
			$JaS_Gallery = $data->JaS_Gallery;
			$JaS_Location = $data->JaS_Location;
			$JaS_timeout = $data->JaS_timeout;
			$JaS_width = $data->JaS_width;
			$JaS_height = $data->JaS_height;
			$JaS_slideWidth = $data->JaS_slideWidth;
			$JaS_slideHeight = $data->JaS_slideHeight;
			$JaS_tabWidth = $data->JaS_tabWidth;
			$JaS_Random = $data->JaS_Random;
			$JaS_speed = $data->JaS_speed;
			$JaS_trigger = $data->JaS_trigger;
			$JaS_pause = $data->JaS_pause;
			$JaS_invert = $data->JaS_invert;
			$JaS_easing = $data->JaS_easing;
		}
		
		$siteurl_link = get_option('siteurl') . "/";
		$f_dirHandle = opendir($JaS_Location);
		$JasImg = "";
		while ($f_file = readdir($f_dirHandle)) 
		{
			if(!is_dir($f_file) && (strpos($f_file, '.jpg')>0 or strpos($f_file, '.gif')>0 or strpos($f_file, '.png')>0)) 
			{
				$JasImg = $JasImg ."<li><img src='".$siteurl_link . $JaS_Location . $f_file ."' /></li>";
			}
		}
		?>
		<div id="mod-jt-zaccordion" style=" widows:<?php echo $JaS_width; ?>px; height: <?php echo $JaS_height; ?>px;">
			<ul id="jt-zaccordion">
				<?php echo $JasImg; ?>
			</ul>
		</div>
		<div style="clear:both;"></div>
		<script type="text/javascript">
		jQuery.noConflict();
		jQuery(document).ready(function() {	
			jQuery("#jt-zaccordion").zAccordion({
			timeout: <?php echo $JaS_timeout; ?>, /* Time between each slide (in ms) */
			width: <?php echo $JaS_width;?>, /* Width of the container (in px) */
			height: <?php echo $JaS_height;?>, /* Height of the container (in px) */
			slideWidth: <?php echo $JaS_slideWidth;?>, /* Width of each slide (in px) */
			slideHeight: <?php echo $JaS_slideHeight;?>, /* Height of each slide (in px) */
			tabWidth: <?php echo $JaS_tabWidth;?>, /* Width of each slide's "tab" (when clicked it opens the slide) */
			speed: <?php echo $JaS_speed; ?>, /* Speed of the slide transition (in ms) */
			trigger: "<?php echo $JaS_trigger; ?>", /* Event type that will bind to the "tab" (click, mouseover, etc.) */
			pause: <?php echo $JaS_pause; ?>, /* Pause on hover */
			invert: <?php echo $JaS_invert; ?>, /* Whether or not to invert the slideshow, so the last slide stays in the same position, rather than the first slide */
			<?php if ($JaS_easing != "null") { ?> easing: "<?php echo $JaS_easing;?>" <?php } else {?> easing: null <?php } ?>
			});
		});
		</script>
		<?php
	}
	else
	{
		echo "No date available for the group GALLERY1";
	}
}

function JaS_install() 
{
	global $wpdb;
	if($wpdb->get_var("show tables like '". WpJqueryAccordionSlidshowTbl . "'") != WpJqueryAccordionSlidshowTbl) 
	{
		$sSql = "CREATE TABLE IF NOT EXISTS `". WpJqueryAccordionSlidshowTbl . "` (";
		$sSql = $sSql . "`JaS_id` INT NOT NULL AUTO_INCREMENT ,";
		$sSql = $sSql . "`JaS_Location` VARCHAR( 1024 ) NOT NULL ,";
		$sSql = $sSql . "`JaS_Gallery` VARCHAR( 15 ) NOT NULL ,";
		$sSql = $sSql . "`JaS_timeout` VARCHAR( 4 ) NOT NULL ,";
		$sSql = $sSql . "`JaS_width` VARCHAR( 4 ) NOT NULL ,";
		$sSql = $sSql . "`JaS_height` VARCHAR( 4 ) NOT NULL ,";
		$sSql = $sSql . "`JaS_slideWidth` VARCHAR( 4 ) NOT NULL ,";
		$sSql = $sSql . "`JaS_slideHeight` VARCHAR( 4 ) NOT NULL ,";
		$sSql = $sSql . "`JaS_tabWidth` VARCHAR( 4 ) NOT NULL ,";
		$sSql = $sSql . "`JaS_Random` VARCHAR( 4 ) NOT NULL ,";
		$sSql = $sSql . "`JaS_speed` VARCHAR( 4 ) NOT NULL ,";
		$sSql = $sSql . "`JaS_trigger` VARCHAR( 10 ) NOT NULL ,";
		$sSql = $sSql . "`JaS_pause` VARCHAR( 6 ) NOT NULL ,";
		$sSql = $sSql . "`JaS_invert` VARCHAR( 6 ) NOT NULL ,";
		$sSql = $sSql . "`JaS_easing` VARCHAR( 6 ) NOT NULL ,";
		$sSql = $sSql . "`JaS_Date` datetime NOT NULL default '0000-00-00 00:00:00' ,";
		$sSql = $sSql . "PRIMARY KEY ( `JaS_id` )";
		$sSql = $sSql . ") ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
		$wpdb->query($sSql);
		
		$sSql = "";
		$IsSql = "INSERT INTO `". WpJqueryAccordionSlidshowTbl . "` (`JaS_Location`, `JaS_Gallery`, `JaS_timeout`, `JaS_width` , `JaS_height` , `JaS_slideWidth` , `JaS_slideHeight` , `JaS_tabWidth` , `JaS_Random` , `JaS_speed` , `JaS_trigger` , `JaS_pause` , `JaS_invert` , `JaS_easing` , `JaS_Date`)"; 
		$sSql = $IsSql . " VALUES ('wp-content/plugins/jquery-accordion-slideshow/gallery1/', 'GALLERY1', '6000', '250', '150', '200', '150', '27', 'YES', '1200', 'click', 'true', 'false', 'null', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		$sSql = $IsSql . " VALUES ('wp-content/plugins/jquery-accordion-slideshow/gallery2/', 'GALLERY2', '6000', '600', '300', '500', '300', '25', 'YES', '1200', 'click', 'true', 'false', 'null', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
	}
	add_option('JaS_Title', "Jquery accordion slideshow");
}

function JaS_admin_options() 
{
	//include_once("image-management.php");
	global $wpdb;
	$current_page = isset($_GET['ac']) ? $_GET['ac'] : '';
	switch($current_page)
	{
		case 'edit':
			include('pages/image-edit.php');
			break;
		case 'add':
			include('pages/image-add.php');
			break;
		case 'set':
			include('pages/widget-setting.php');
			break;
		default:
			include('pages/image-show.php');
			break;
	}
}

function JaS_shortcode( $atts ) 
{
	global $wpdb;
	$Jas = "";
	if ( ! is_array( $atts ) )
	{
		return '';
	}
	$scode = $atts['gallery'];
	//[jquery-accordion gallery="GALLERY1"]
	
	$sSql = "select * from ".WpJqueryAccordionSlidshowTbl." where JaS_Gallery = '$scode'";
	$sSql = $sSql . " order by rand() limit 0,1;";
	//echo $sSql ;
	$data = $wpdb->get_results($sSql);
	if ( ! empty($data) ) 
	{
		$li = "";
		foreach ( $data as $data ) 
		{
			$JaS_Gallery = $data->JaS_Gallery;
			$JaS_Location = $data->JaS_Location;
			$JaS_timeout = $data->JaS_timeout;
			$JaS_width = $data->JaS_width;
			$JaS_height = $data->JaS_height;
			$JaS_slideWidth = $data->JaS_slideWidth;
			$JaS_slideHeight = $data->JaS_slideHeight;
			$JaS_tabWidth = $data->JaS_tabWidth;
			$JaS_Random = $data->JaS_Random;
			$JaS_speed = $data->JaS_speed;
			$JaS_trigger = $data->JaS_trigger;
			$JaS_pause = $data->JaS_pause;
			$JaS_invert = $data->JaS_invert;
			$JaS_easing = $data->JaS_easing;
		}
		
		$easing = "null";
		if ($JaS_easing != "null") 
		{ 
			$easing = $JaS_easing;
		} 
		else 
		{
			$easing = "null";
		}
		      
		$siteurl_link = get_option('siteurl') . "/";
		$f_dirHandle = opendir($JaS_Location);
		$JasImg = "";
		while ($f_file = readdir($f_dirHandle)) 
		{
			if(!is_dir($f_file) && (strpos($f_file, '.jpg')>0 or strpos($f_file, '.gif')>0 or strpos($f_file, '.png')>0)) 
			{
				$JasImg = $JasImg ."<li><img src='".$siteurl_link . $JaS_Location . $f_file ."' /></li>";
			}
		}

		$Jas = '<div id="mod-jt-zaccordion" style=" widows:'.$JaS_width.'px; height: '.$JaS_height.'px;"> ';
			$Jas = $Jas . '<ul id="jt-zaccordion"> ';
				$Jas = $Jas . $JasImg;
			$Jas = $Jas . '</ul> ';
		$Jas = $Jas . '</div> ';
		$Jas = $Jas . '<div style="clear:both;"></div> ';
		
		$Jas = $Jas . '<script type="text/javascript"> ';
		$Jas = $Jas . 'jQuery.noConflict(); ';
		$Jas = $Jas . 'jQuery(document).ready(function() {	';
			$Jas = $Jas . 'jQuery("#jt-zaccordion").zAccordion({ ';
			$Jas = $Jas . 'timeout: '.$JaS_timeout.', ';
			$Jas = $Jas . 'width: '.$JaS_width.', ';
			$Jas = $Jas . 'height: '.$JaS_height.', ';
			$Jas = $Jas . 'slideWidth: '.$JaS_slideWidth.', ';
			$Jas = $Jas . 'slideHeight: '.$JaS_slideHeight.', ';
			$Jas = $Jas . 'tabWidth: '.$JaS_tabWidth.', ';
			$Jas = $Jas . 'speed: '.$JaS_speed.', ';
			$Jas = $Jas . 'trigger: "'.$JaS_trigger.'", ';
			$Jas = $Jas . 'pause: '.$JaS_pause.', ';
			$Jas = $Jas . 'invert: '.$JaS_invert.', ';
			$Jas = $Jas . 'easing: '.$easing.' ';
			$Jas = $Jas . '}); ';
		$Jas = $Jas . '}); ';
		$Jas = $Jas . '</script> ';
	
	}
	else
	{
		$Jas = "No date available for this group";
	}
	return $Jas;
}

function JaS_deactivation() 
{
	// No action required.
}

function JaS_add_javascript_files() 
{
	if (!is_admin())
	{
		wp_enqueue_script('jquery');
		wp_enqueue_script( 'jquery.zaccordion.min', WP_JaS_PLUGIN_URL.'/js/jquery.zaccordion.min.js');
		wp_enqueue_script( 'jquery.easing.1.3', WP_JaS_PLUGIN_URL.'/js/jquery.easing.1.3.js');
	}	
}

function JaS_add_to_menu() 
{
	add_options_page(__('Jquery accordion slideshow', 'jquery-accordion'), 
						__('Jquery accordion slideshow', 'jquery-accordion'), 'manage_options', 'jquery-accordion-slideshow', 'JaS_admin_options' );
}

if (is_admin()) 
{
	add_action('admin_menu', 'JaS_add_to_menu');
}

function JaS_widget($args) 
{
	extract($args);
	echo $before_widget . $before_title;
	echo get_option('JaS_Title');
	echo $after_title;
	JaSShow();
	echo $after_widget;
}

function JaS_control() 
{
	echo '<p><b>';
	_e('Jquery accordion slideshow', 'jquery-accordion');
	echo '.</b> ';
	_e('Check official website for more information', 'jquery-accordion');
	?> <a target="_blank" href="<?php echo Wp_JaS_FAV; ?>"><?php _e('click here', 'jquery-accordion'); ?></a></p><?php
}

function JaS_init()
{
	if(function_exists('wp_register_sidebar_widget')) 
	{
		wp_register_sidebar_widget(__('Jquery accordion slideshow', 'jquery-accordion'), 
					__('Jquery accordion slideshow', 'jquery-accordion'), 'JaS_widget');
	}
	
	if(function_exists('wp_register_widget_control')) 
	{
		wp_register_widget_control(__('Jquery accordion slideshow', 'jquery-accordion'), 
					array( __('Jquery accordion slideshow', 'jquery-accordion'), 'widgets'), 'JaS_control');
	} 
}

function JaS_textdomain() 
{
	  load_plugin_textdomain( 'jquery-accordion', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

add_action('plugins_loaded', 'JaS_textdomain');
add_shortcode( 'jquery-accordion', 'JaS_shortcode' );
add_action('wp_enqueue_scripts', 'JaS_add_javascript_files');
add_action("plugins_loaded", "JaS_init");
register_activation_hook(__FILE__, 'JaS_install');
register_deactivation_hook(__FILE__, 'JaS_deactivation');
?>