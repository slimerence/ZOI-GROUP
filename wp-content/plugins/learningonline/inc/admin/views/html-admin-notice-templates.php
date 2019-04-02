<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( learning_online_get_user_option( 'hide-notice-template-files' ) == 'yes' ) {
	return;
}
$template_dir   = get_template_directory();
$stylesheet_dir = get_stylesheet_directory();
$cradle         = learning_online_detect_outdated_template();
$theme          = wp_get_theme();
$theme_name     = array();

if ( $template_dir === $stylesheet_dir ) {
	$theme_name[] = $theme['Name'];
} else {
	if ( $cradle['parent_item'] ) {
		$theme_name[] = $parent = $theme->__get( 'parent_theme' );
	}
	if ( $cradle['child_item'] ) {
		$theme_name[] = $theme['Name'];
	}
}
$theme_name = implode( ' & ', $theme_name );


?>
<div id="message" class="learning-online-message notice notice-warning">
    <p>
		<?php printf( __( 'There is a new update of LearningOnline. You may need to update your theme <strong>(%s)</strong> to avoid outdated template files.', 'learningonline' ), esc_html( $theme_name ) ); ?>
    </p>
    <p class="outdated-readmore-link">
		<?php printf( __( 'This is not a bug, don\'t worry. Read more about Outdated template files notice <a href="%s" target="_blank">here</a>.', 'learningonline' ), 'https://jwstheme.com/knowledge-base/outdated-template-fix/' ); ?>
    </p>
    <p>
        <a class="button"
           href="<?php echo esc_url( admin_url( 'admin.php?page=learning-online-tools&tab=templates' ) ); ?>"><?php _e( 'View list of outdated templates', 'learningonline' ); ?></a>
    </p>
    <a href="<?php echo esc_url( add_query_arg( 'lp-hide-notice', 'template-files', learning_online_get_current_url() ) ); ?>"
       class="learning-online-admin-notice-dismiss"></a>
</div>
