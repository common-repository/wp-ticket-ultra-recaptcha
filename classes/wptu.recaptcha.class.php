<?php
class WPTicketUltraComplementReCaptcha
{
	var $RECAPTCHA_SITE_KEY;
	var $RECAPTCHA_SECRET_KEY;
		
	public function __construct()
	{		
		/* Plugin slug and version */
		$this->slug = 'wpticketultra';
		$this->subslug = 'wptu-recaptcha';
		require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		$this->plugin_data = get_plugin_data( wptu_recaptcha_path . 'index.php', false, false);
		$this->version = $this->plugin_data['Version'];		
					
		add_action('wp_enqueue_scripts', array(&$this, 'add_front_end_scripts'), 12);	
		
		
    }
	
	function add_front_end_scripts() {
		
		wp_enqueue_script( 'wptu_recaptcha_js', 'https://www.google.com/recaptcha/api.js' );
		
	}
	
	function recaptcha_field() {
		
		global  $wpticketultra;
		
		$RECAPTCHA_SITE_KEY = $wpticketultra->get_option('recaptcha_site_key');
		$RECAPTCHA_SECRET_KEY= $wpticketultra->get_option('recaptcha_secret_key');
    
		$html = '
		<fieldset>
			<label>'.__( "Are you human?", "wp-ticket-ultra" ).'</label>
			<div class="field">
				<div class="g-recaptcha" data-sitekey="'.$RECAPTCHA_SITE_KEY.'"></div>
			</div>
		</fieldset>';
		
		return $html;
	
	}
	
	function validate_recaptcha_field($grecaptcharesponse) {		
		
		global  $wpticketultra;
		
		$RECAPTCHA_SITE_KEY = $wpticketultra->get_option('recaptcha_site_key');
		$RECAPTCHA_SECRET_KEY= $wpticketultra->get_option('recaptcha_secret_key');    
		
		$response = wp_remote_get( add_query_arg( array(
			'secret'   => $RECAPTCHA_SECRET_KEY,
			'response' => $grecaptcharesponse,
			'remoteip' => isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']
		), 'https://www.google.com/recaptcha/api/siteverify' ) );
		
		if ( is_wp_error( $response ) || empty( $response['body'] ) || ! ( $json = json_decode( $response['body'] ) ) || ! $json->success ) {
						
			$result = false;
			
		}else{
			
			$result = true;
			
		}
		
		return $result;
	}
	
	function validation_d(){
		
		 $recaptcha_secret = "Add Your Secret Key";
		$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$recaptcha_secret."&response=".$_POST['g-recaptcha-response']);
		$response = json_decode($response, true);
	
	
		if($response["success"] === true){
			echo "Form Submit Successfully.";
		}else{
			echo "You are a robot";
		}
		
	
	}

}
?>