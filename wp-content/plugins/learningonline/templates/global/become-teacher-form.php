<?php
/**
 * Template for displaying the form let user fill out their information to become a teacher
 *
 * @author        JwsTheme
 * @package       LearningOnline/Templates
 * @version       1.0
 */

$request                    = $method == 'post' ? $_POST : $_REQUEST;
$form_id                    = uniqid( 'become-teacher-form-' );
$submit_button_process_text = __( 'Submitting...', 'learningonline' );
$submit_button_text         = __( 'Submit', 'learningonline' );
?>
<div id="learning-online-become-teacher-form" class="learning-online-become-teacher-form">
	<?php 	if( $message ) {
				learning_online_display_message( $message );
			} 
	?>
	<?php if ( !learning_online_become_teacher_sent() ): ?>
		<form id="<?php echo $form_id; ?>" name="become-teacher-form" method="<?php echo $method; ?>" enctype="multipart/form-data" action="<?php echo $action; ?>">
			<?php if ( $fields ): ?>
				<ul class="become-teacher-fields">
					<?php foreach ( $fields as $name => $option ): ?>
						<?php
						$option        = wp_parse_args(
							$option,
							array(
								'title'       => '',
								'type'        => '',
								'def'         => '',
								'placeholder' => ''
							)
						);
						$value         = !empty( $request[$name] ) ? $request[$name] : ( !empty( $option['def'] ) ? $option['def'] : '' );
						$requested     = strtolower( $_SERVER['REQUEST_METHOD'] ) == $method;
						$error_message = null;
						if ( $requested ) {
							$error_message = apply_filters( 'learning_online_become_teacher_form_validate_' . $name, $value );
						}

						?>
						<li>
							<label><?php echo $option['title']; ?></label>
							<?php
							switch ( $option['type'] ) {
								case 'text':
								case 'email':
									printf( '<input type="%s" name="%s" placeholder="%s" value="%s" />', $option['type'], $name, $option['placeholder'], esc_attr( $value ) );
									break;
							}
							if ( $error_message ) {
								learning_online_display_message( $error_message );
							}
							?>
						</li>
					<?php endforeach; ?>
					<li>
						<button type="submit" data-text="<?php echo esc_attr( $submit_button_text ); ?>" data-text-process="<?php echo esc_attr( $submit_button_process_text ); ?>"><?php echo esc_html( $submit_button_text ); ?></button>
					</li>
				</ul>
				<input type="hidden" name="lp-ajax" value="become-a-teacher" />
			<?php endif; ?>
		</form>
	<?php endif; ?>
</div>
