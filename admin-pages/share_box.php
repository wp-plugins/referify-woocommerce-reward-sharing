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
			
			<?php add_iframe_content( 'preview' ) ;?>
			
			<br/>
			
			<p>To edit the share box settings, please click the button below which will take you to your Referify account</p>

			<a href="http://referify.co.uk/retailer/iframe" target="_blank"><div class="button button-primary">Manage Share Box</div></a>
		
		<?php } ?>

	</div>