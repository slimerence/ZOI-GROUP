<h2><?php _e( 'Upgrade complete successfully!', 'learningonline' ); ?></h2>
<h3 style="font-size: 14px;"><?php _e( 'What\'s next?', 'learningonline' ); ?></h3>
<ul>
	<li>
		<a href="<?php echo admin_url( 'edit.php?post_type=lp_course' ); ?>"><?php _e( 'Manage courses', 'learningonline' ); ?></a>
	</li>
	<li>
		<a href="<?php echo admin_url( 'post-new.php?post_type=lp_course' ); ?>"><?php _e( 'Create a new course', 'learningonline' ); ?></a>
	</li>
	<li>
		<a href="<?php echo admin_url( 'options-general.php?page=learning-online-settings' ); ?>"><?php _e( 'Setting up your LearningOnline', 'learningonline' ); ?></a>
	</li>
	<li>
		<a href="<?php echo admin_url( 'admin.php?page=learning-online-addons' ); ?>"><?php _e( 'Manage add-ons', 'learningonline' ); ?></a>
	</li>
	<li><a href="<?php echo admin_url( 'index.php' ); ?>"><?php _e( 'Dashboard', 'learningonline' ); ?></a></li>
</ul>