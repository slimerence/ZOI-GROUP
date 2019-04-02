<?php

function jws_theme_login_form_func($atts, $content = null) {

    extract(shortcode_atts(array(

        'link_facebook' => '#',

        'link_twitter' => '#',

        'el_class' => ''

    ), $atts));

	

    $class = array();

	$class[] = 'tb-login-form';

	$class[] = $el_class;

    ob_start();

    ?>

		<div class="<?php echo esc_attr(implode(' ', $class)); ?>">

			<h5 class="tb-title"><?php _e('Login', 'eduonline'); ?></h5>

			<p><?php _e('Hello, Welcome your to account', 'eduonline'); ?></p>

			<div class="tb-social-login">

				<a class="tb-facebook-login" href="<?php echo esc_url($link_facebook); ?>"><i class="fa fa-facebook"></i><?php _e('Sign In With Facebook', 'eduonline') ?></a>

				<a class="tb-twitter-login" href="<?php echo esc_url($link_twitter); ?>"><i class="fa fa-twitter"></i><?php _e('Sign In With Twitter', 'eduonline') ?></a>

			</div>

			<?php

				$args = array(

					'echo'           => true,

					'remember'       => true,

					'redirect'       => home_url('/'),

					'form_id'        => 'loginform',

					'id_username'    => 'user_login',

					'id_password'    => 'user_pass',

					'id_remember'    => 'rememberme',

					'id_submit'      => 'wp-submit',

					'label_username' => __( 'Email Address', 'eduonline' ),

					'label_password' => __( 'Password', 'eduonline' ),

					'label_remember' => __( 'Remember me!', 'eduonline' ),

					'label_log_in'   => __( 'LogIn', 'eduonline' ),

					'value_username' => '',

					'value_remember' => false

				);

				wp_login_form($args); 

			?>

		</div>

		

    <?php

    return ob_get_clean();

}

if(function_exists('insert_shortcode')) { insert_shortcode('login_form', 'jws_theme_login_form_func');}



add_action( 'login_form_middle', 'jws_theme_add_lost_password_link' );

function jws_theme_add_lost_password_link() {

    return '<a class="forgot-password" href="'.wp_lostpassword_url().'" title="Forgot Your password">Forgot Your password?</a>';

}



/*-------------------------------------------------------------------------------------*/

/* Login Hooks and Filters

/*-------------------------------------------------------------------------------------*/

/*if( ! function_exists( 'jws_theme_custom_login_fail' ) ) {

    function jws_theme_custom_login_fail( $username ) {

        $referrer = $_SERVER['HTTP_REFERER']; // where did the post submission come from?

        // if there's a valid referrer, and it's not the default log-in screen

        if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') ) {

            if ( !strstr($referrer,'?login=failed') ) { // make sure we don’t append twice

                wp_redirect( $referrer . '?login=failed' ); // append some information (login=failed) to the URL for the theme to use

            } else {

                wp_redirect( $referrer );

            }

            exit;

        }

    }

}

add_action( 'wp_login_failed', 'jws_theme_custom_login_fail' ); // hook failed login



if( ! function_exists( 'jws_theme_custom_login_empty' ) ) {

    function jws_theme_custom_login_empty(){

        $referrer = $_SERVER['HTTP_REFERER'];

        if ( strstr($referrer,get_home_url()) && $user==null ) { // mylogin is the name of the loginpage.

            if ( !strstr($referrer,'?login=empty') ) { // prevent appending twice

                wp_redirect( $referrer . '?login=empty' );

            } else {

                wp_redirect( $referrer );

            }

        }

    }

}

add_action( 'authenticate', 'jws_theme_custom_login_empty');

*/