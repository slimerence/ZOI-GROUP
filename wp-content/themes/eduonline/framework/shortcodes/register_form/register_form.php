<?php

function jws_theme_register_form_func($atts, $content = null) {

    extract(shortcode_atts(array(

        'el_class' => ''

    ), $atts));

	

    $class = array();

	$class[] = 'tb-register-form';

	$class[] = $el_class;

    ob_start();

    ?>

	<div class="<?php echo esc_attr(implode(' ', $class)); ?>">

		<h5 class="tb-title"><?php _e('Create a new account', 'eduonline'); ?></h5>

		<p><?php _e('Create your own Unicase account', 'eduonline'); ?></p>

		<?php

			$http_post = ('POST' == $_SERVER['REQUEST_METHOD']);

			$user_email = '';

			if ( $http_post ) {

                $user_email = isset( $_POST['user_email'] ) ? $_POST['user_email'] : '';

				

				$user_pass = wp_generate_password( 12, false );

				$user_id = wp_create_user( $user_email, $user_pass, $user_email );

				if ( ! $user_id || is_wp_error( $user_id ) ) {

					echo '<p class="tb-registerform-message error">Register Faild.</p>';

				}else {

					echo '<p class="tb-registerform-message complete">Register Complete. Please check mail.</p>';

					

					$subject = 'The eduonline';

					$content = 'Username: '.$user_email.' Password: '.$user_pass;

					wp_mail( $user_email, $subject, $content );

				}

			}

		?>

		<form name="tb-registerform" id="tb-registerform" action="" method="post" novalidate="novalidate">

			<p>

				<label for="user_email"><?php _e('Email Address','eduonline') ?></label>

				<input type="email" name="user_email" id="user_email" class="input" value="<?php echo esc_attr( wp_unslash( $user_email ) ); ?>" />

			</p>

			<p class="submit">

				<input type="submit" name="tb-wp-submit" id="tb-wp-submit" class="btn-pre-v2" value="<?php _e('SignUp','eduonline'); ?>" />

			</p>

		</form>

		<div class="tb-info">

			<h5><?php _e('SignUp today and you\'ll be able to:', 'eduonline'); ?></h5>

			<ul>

				<li><?php _e('Speed your way through the checkout.', 'eduonline'); ?></li>

				<li><?php _e('Track your orders easily.', 'eduonline'); ?></li>

				<li><?php _e('Keep a record of all your purchases.', 'eduonline'); ?></li>

			</ul>

		</div>

	</div>

		

    <?php

    return ob_get_clean();

}

if(function_exists('insert_shortcode')) { insert_shortcode('register_form', 'jws_theme_register_form_func');}

