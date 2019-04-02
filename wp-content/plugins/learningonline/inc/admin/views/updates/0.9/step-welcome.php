<h2><?php _e( 'Welcome to LearningOnline!', 'learningonline' ); ?></h2>
<p><?php _e( 'Thank you for choosing LearningOnline to sell your courses online!', 'learningonline' ); ?></p>
<p><?php printf( __( 'In version <strong>%s</strong> of LearningOnline we have a big update and need to upgrade your database to ensure system works properly.', 'learningonline' ), learning_online_get_current_version() ); ?></p>
<p><?php _e( 'We are very careful in upgrading the database but be sure to backup your database before upgrading to avoid the risks may be encountered.', 'learningonline' ); ?></p>
<p><?php _e( 'Click <strong>Yes, upgrade!</strong> button to start.', 'learningonline' ); ?></p>
<p class="lp-update-actions">
	<a href="<?php echo esc_url( admin_url( '' ) ); ?>" class="button"><?php _e( 'No, back to Admin', 'learningonline' ); ?></a>
	<a id="learning-online-update-button" class="button-primary button"><?php _e( 'Yes, upgrade!', 'learningonline' ); ?></a>
</p>
<input type="hidden" name="action" value="upgrade" />