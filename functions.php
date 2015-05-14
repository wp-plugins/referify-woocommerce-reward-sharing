<?php

add_action( 'admin_post_referify_settings', 'prefix_admin_referify_settings' );
function prefix_admin_referify_settings() {
    	
	$updated = false;

	if( isset( $_POST['referify_retailer_id'] ) ){

		$referify_retailer_id = sanitize_text_field( trim( $_POST['referify_retailer_id'] ) );
	
		$result = update_option( "referify_retailer_id", $referify_retailer_id );
		
		$updated = true;
		
	}

	if( isset( $_POST['referify_share_box'] ) ){
		
		$referify_share_box = sanitize_text_field( trim( $_POST['referify_share_box'] ) );

		$result = update_option( "referify_share_box", $referify_share_box );
		
		$updated = true;
		
	}	

	if( isset( $_POST['referify_server_secret'] ) ){
		
		$referify_server_secret = sanitize_text_field( trim( $_POST['referify_server_secret'] ) );

		$result = update_option( "referify_server_secret", $referify_server_secret );
		
		$updated = true;
		
	}	
	
	if( $updated ) {
		
		wp_safe_redirect( admin_url( 'admin.php?page=referify&update=true' ) );
		
	} else {
		
		wp_safe_redirect( admin_url( 'admin.php?page=referify&update=false' ) );
		
	}
	
}





// help text
function referify_add_help_tab( ) {
	
	$help_text = array();
	
	$help_text['toplevel_page_referify'] = "<p>This screen let's you view all competitions that are set up. Competition entry is collected via a Contact Form 7 form on your website</p>
								<p>On this screen you can:</p>								
								<p><strong>Add New</strong> - You can set up a new competition. You need to ensure that you have already set up the form in the Contact Form 7 plugin</p>
								<p><strong>Delete</strong> - Deletes a competition (note that all entries will also be deleted).</p>
								<p>You can also see how many entries, and winners there are</p>
									";
	$help_text['share_box'] = "<p>This screen let's you view all competitions that are set up. Competition entry is collected via a Contact Form 7 form on your website</p>
								<p>On this screen you can:</p>								
								<p><strong>Add New</strong> - You can set up a new competition. You need to ensure that you have already set up the form in the Contact Form 7 plugin</p>
								<p><strong>Delete</strong> - Deletes a competition (note that all entries will also be deleted).</p>
								<p>You can also see how many entries, and winners there are</p>
									";

									
	$screen = get_current_screen();

	if( isset( $help_text[ $screen->base ] ) ) {
	
		$screen->add_help_tab( array( 
		   'id' => 'referify_help',            
		   'title' => 'Overview',      //unique visible title for the tab
		   'content' => $help_text[ $screen->base ],  //actual help text
		) );			
		
	}
	
	
}
