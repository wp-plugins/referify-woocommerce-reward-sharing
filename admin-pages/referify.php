<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

	<div class="wrap">
	
		<?php 
		if( isset( $_GET['update'] ) && sanitize_text_field( $_GET['update'] ) == 'true' ) {
			
			echo "<div id='message' class='updated fade'><p><strong>Your settings have been saved.</strong></p></div>";
			
		}
		if( isset( $_GET['update'] ) && sanitize_text_field( $_GET['update'] ) == 'false' ) {
			
			echo "<div id='message' class='error fade'><p><strong>There has been a problem. Please try again.</strong></p></div>";
			
		}		
		
		// get variables
		$REFERIFY_RETAILER_ID = get_option( "referify_retailer_id", false );
		$REFERIFY_SERVER_SECRET = get_option( "referify_server_secret", false );
		$REFERIFY_SHARE_BOX = get_option( "referify_share_box", false );		
		
		if( isset( $_SERVER['SERVER_NAME'] ) ) {
			$domain_name = $_SERVER['SERVER_NAME'];
		} else {
			$domain_name = "";	
		}
		
		?>
		
		<h2>Referify</h2>
		
		<hr/>	
		<br/>
		
		<?php if( ! $REFERIFY_RETAILER_ID ) { ?>
		
		<h3>Referify Sign Up</h3>
		
		<p>Referify turns your consumers into brand ambassadors, by offering an incentive to share your website with their friends and family.</p>
		
		<p>To use Referify, please sign up first at Referify using the button below, and once complete, insert your unqique Referify Retailer ID & Server API secret below, to ensure all sales and shares are tracked</p>
		
		<a href="http://referify.co.uk/auth/register/retailer?domain=<?php echo $domain_name;?>" target="_blank"><div class="button button-primary">Referify Sign Up</div></a>
		
		<br/>
		<br/>
		<hr/>
		<br/>
		
		<?php } ?>
		
		<h3>Referify ID's</h3>
		
		<p>To access your ID's, login to your Referify account, and go to 'Profile' where you will find these ID's. Insert them below, and click Update to activate Referify on your website.</p>

		<form method="post" action="<?php echo admin_url( 'admin-post.php' ); ?>" > 

			<div class="form-field form-required">
				<label for="referify_retailer_id">Your Referify Retailer ID:</label><br/>
				<input id="referify_retailer_id" type="text" size="40" style="width:320px;" width="350px" value="<?php if( $REFERIFY_RETAILER_ID ) { echo $REFERIFY_RETAILER_ID ;} ?>" name="referify_retailer_id"></input>
			</div>	
			
			<br/>
			
			<div class="form-field form-required">
				<label for="referify_server_secret">Your Server API Secret:</label><br/>
				<input id="referify_server_secret" type="text" size="40" style="width:320px;" width="350px" value="<?php if( $REFERIFY_SERVER_SECRET ) { echo $REFERIFY_SERVER_SECRET ;} ?>" name="referify_server_secret"></input>
			</div>	
			
			<!--
			<br/>			
			<div class="form-field form-required">
				<label for="referify_share_box">Share box visible on your thank your page:</label><br/>
				<select id="referify_share_box" type="text" name="referify_share_box" >
					<option value="on" <?php if( $REFERIFY_SHARE_BOX != 'off' ) { echo "selected"; }?> >On</option>
					<option value="off" <?php if( $REFERIFY_SHARE_BOX == 'off' ) { echo "selected"; }?> >Off</option>
				</select>
			</div>	
			-->
			
			<p class="submit">
				<input id="submit" class="button button-primary" type="submit" value="Update" name="submit"></input>
			</p>
			
			<input type="hidden" name="action" value="referify_settings">
				
		</form>

		

	</div>
