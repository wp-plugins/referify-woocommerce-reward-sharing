<?php
/*
 * Plugin Name: Referify WooCommerce Reward Social Sharing
 * Plugin URI: 
 * Description: Incentivise your customers to share your website by offering cashback
 * Version:  1.3
 * Author: Referify
 * Author URI: http://www.referify.co.uk
 * Developer: RaiserWeb
 * Developer URI: http://www.raiserweb.com
 * Text Domain: raiserweb
 * License: GPLv2
 *
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License, version 2, as
 *  published by the Free Software Foundation.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */
 
 
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


 
// include plugin files
include( 'functions.php' );
/* required plugin */
include( 'required_plugin/required-plugins.php' );


if( is_admin() ) {
	

	// admin pages and help
	add_action( 'admin_menu', 'referify_admin_menu' );	
	function referify_admin_menu() {
	
		$referify_pages['referify'] = add_menu_page( 'Referify', 'Referify', 'manage_options', 'referify', 'Referify', 'dashicons-share', 51 );
		$referify_pages['share_box'] = add_submenu_page( 'referify', 'Share Box', 'Share Box', 'manage_options', 'share_box', 'referify_share_box' );
		
		// add help
		/*
		foreach( $referify_pages as $page ) {
		
			add_action('load-'.$page, 'referify_add_help_tab');	
		
		}
		*/
	}

	// admin screens
	function referify() {		
		include( 'admin-pages/referify.php' );
	}

	function referify_share_box() {		
		include( 'admin-pages/share_box.php' );
	}
	
}


// add shortcode
add_shortcode('referify-share-box', 'referify_share_box_short_code');
function referify_share_box_short_code(){
	
	add_iframe_content();
	
}



// test if woo commerce is active
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	
	// add referred box script to every page
	add_action('wp_footer', 'add_referred_box_script');	
	function add_referred_box_script(){
		$REFERIFY_RETAILER_ID = get_option( "referify_retailer_id", false );
		if( $REFERIFY_RETAILER_ID ) { ?>
		<script type="text/javascript">
			function getParameterByName_rfer1(name) {
				name = name.replace(/[\[]/, "\[").replace(/[\]]/, "\]");
				var regex = new RegExp("[\?&]" + name + "=([^&#]*)"),
				results = regex.exec(location.search);
				return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
			}
			if( getParameterByName_rfer1("rfer") == "true" ) {
			(function() {		
				var a = document.createElement("script");
				a.type= "text/javascript";
				a.src = ("https:" == document.location.protocol ? "https://" : "http://") + "track.referify.co.uk/referred_box/<?php echo $REFERIFY_RETAILER_ID;?>.js";
				a.async = true;		
				document.getElementsByTagName("body")[0].appendChild(a);
			})();
			}			
		</script>
		<?php }
	} 

	// add text to the thank you page 
	add_action( 'woocommerce_thankyou', 'add_iframe_content', 1 ); 
	function add_iframe_content( $order_id = '' ) {

		$REFERIFY_RETAILER_ID = get_option( "referify_retailer_id", false );
		$REFERIFY_SHARE_BOX = get_option( "referify_share_box", false );	
		$REFERIFY_SERVER_SECRET = get_option( "referify_server_secret", false );
		
		if( $order_id == 'preview' ) {

			if( $REFERIFY_RETAILER_ID ) {
				
				//$iframe = '<iframe src="http://referify.co.uk/iframe/'.$REFERIFY_RETAILER_ID.'?preview=true" width="320" height="400" frameBorder="0" ></iframe>';
				$iframe = '
				<div id="referify_iframe" style="text-align:center;"></div>
				<script type="text/javascript">
				(function() {	
					var a = document.createElement("iframe");
					a.width="320";
					a.height="400";
					a.frameBorder="0";
					a.src = ("https:" == document.location.protocol ? "https://" : "http://") + "referify.co.uk/iframe/'.$REFERIFY_RETAILER_ID.'?preview=true";
					document.getElementById("referify_iframe").appendChild(a);
				})();
				</script>				
				';
				echo $iframe;
				
			}	
			
		} else {
			
			if( $REFERIFY_RETAILER_ID && $REFERIFY_SHARE_BOX != 'off' ) {
				
				//$iframe = '<iframe src="http://referify.co.uk/iframe/'.$REFERIFY_RETAILER_ID.'" width="320" height="400" frameBorder="0" ></iframe>';
				
				// if on the thank you page
				if( $order_id == '' ){					
					$billing_email = '';
				} else {
					$order = new WC_Order( $order_id );
					$billing_email = $order->billing_email;
				}
				
				$iframe = '
				<div id="referify_iframe"></div>
				<script type="text/javascript">
				(function() {	
					var a = document.createElement("iframe");
					a.width="320";
					a.height="400";
					a.frameBorder="0";
					a.src = ("https:" == document.location.protocol ? "https://" : "http://") + "referify.co.uk/iframe/'.$REFERIFY_RETAILER_ID.'?email='.$billing_email.'";
					document.getElementById("referify_iframe").appendChild(a);
				})();
				</script>				
				';			
				echo $iframe;
				
			}	
			
		}
		
	}

	// add conversion pixel to thank you page
	add_action( 'woocommerce_thankyou', 'add_conversion_pixel', 1 ); 
	function add_conversion_pixel( $order_id ) {

		$REFERIFY_RETAILER_ID = get_option( "referify_retailer_id", false );
		$REFERIFY_SERVER_SECRET = get_option( "referify_server_secret", false );	
	
		if( $REFERIFY_RETAILER_ID && $REFERIFY_SERVER_SECRET ) {		
		
			// the order
			$order = new WC_Order( $order_id );	

			// create hash
			$hash = sha1( $REFERIFY_SERVER_SECRET . $order->get_total() . $order_id );
		
			// OLD SCRIPT			
			// <script defer="defer" src="http://track.referify.co.uk/'.$REFERIFY_RETAILER_ID.'/s.js" type="text/javascript" ></script>
				
			$pixel = '
				<script type="text/javascript">
				//<![CDATA[
				/*** Do not change ***/
				var REFERIFY = {};
				REFERIFY.Tracking = {};
				REFERIFY.Tracking.Sale = {};
				/*** Set your transaction parameters ***/
				REFERIFY.Tracking.Sale.amount = "'.$order->get_total().'";
				REFERIFY.Tracking.Sale.orderRef = "'.$order_id.'";
				REFERIFY.Tracking.Sale.test = "0";
				REFERIFY.Tracking.key = "'.$hash.'";
				//]]>
				</script>
				<div id="referify_pixel"></div>
				<script type="text/javascript">
				(function() {	
					var datas =
					{
						cbust: (new Date()).getTime(),
					};
					var u="";
					for(var key in datas){u+=key+"="+datas[key]+"&"}
					u=u.substring(0,u.length-1);			
					var a = document.createElement("script");
					a.type= "text/javascript";
					a.src = ("https:" == document.location.protocol ? "https://" : "http://") + "track.referify.co.uk/'.$REFERIFY_RETAILER_ID.'/s.js?" + u;
					a.async = true;	
					a.defer="defer";
					document.getElementById("referify_pixel").appendChild(a);
				})();
				</script>
				';
				
			echo $pixel;
			
		}
	}
	
	

	// --------- WIDGET IN SIDEBAR -----------//
	
	add_action('widgets_init', 'register_referify_widget');
	function register_referify_widget() {
		register_widget('referify_sidebar_widget');
	}

	class referify_sidebar_widget extends WP_Widget {
		
		function referify_sidebar_widget()	{
			$widget_ops = array('classname' => 'cc', 'description' => 'Widget for positioning the Referify Share box in the sidebar or footer');
			$control_ops = array('id_base' => 'referify_sidebar_widget');
			$this->WP_Widget('referify_sidebar_widget', 'Referify', $widget_ops, $control_ops);
		}
		
		function widget($args, $instance) {	
				
			echo $before_widget;
			add_iframe_content();
			echo $after_widget;
			
		}	
	}


	//. --------- WIDGET IN SIDEBAR -----------//	
	
	
}