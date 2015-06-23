<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

		// get variables
		$REFERIFY_RETAILER_ID = get_option( "referify_retailer_id", false );
		$REFERIFY_SERVER_SECRET = get_option( "referify_server_secret", false );
		$REFERIFY_SHARE_BOX = get_option( "referify_share_box", false );	

?>

	<div class="wrap">
	
	
		
		<h2>Share Box Preview</h2>
		
		<hr/>
		
		<?php if( ! $REFERIFY_RETAILER_ID ) { ?>	

			<p>Please add your Referify ID and Server API Secret to see the preview</p>

		<?php } else { ?>
		
			<p>This is a preview of the Referify sharing box, that appears on your thank you page.</p>
			
			<div style="float:left;">
			<?php add_iframe_content( 'preview' ) ;?>
			</div>
			
			<div style="clear:both;"></div>

			<br/>
			
			<h3>Share Box Placement</h3>
			
			<p>You can also use this shortcode to place the share box on any page of your site</p>
			
			<p><input type="text" readonly value="[referify-share-box]"></p>
			
			<strong>Alternatively you can also place this share box within any of your site sidebars, using the Referify widget found in Appearance > Widgets</strong>
			
			<br/>
			
			<br/>
			
			<p>To edit the share box colour settings, please click the button below which will take you to your Referify account</p>

			<a href="http://referify.co.uk/retailer/iframe" target="_blank"><div class="button button-primary">Manage Share Box</div></a>
		
		<?php } ?>

	</div>