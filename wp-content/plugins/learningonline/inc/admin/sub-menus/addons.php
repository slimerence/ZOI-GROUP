<?php
/**
 * Admin view for add-ons page display in admin under menu LearningOnline -> Add ons
 *
 * @author  JwsTheme
 * @package Admin/Views
 * @version 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Add-on page
 */
function learning_online_addons_page() {
	$current = isset( $_GET['tab'] ) ? $_GET['tab'] : '';
        
        $theme = wp_get_theme();
	?>
	<div id="learning-online-add-ons-wrap" class="wrap">
	<h2><?php echo __( 'LearningOnline Add-ons', 'learningonline' ); ?></h2>
	<!-- <p class="top-description"><?php _e( 'Features add-ons that you can add or remove depending on your needs.', 'learningonline' ); ?></p>-->
	<ul class="subsubsub">
		<?php
		do_action( 'learning_online_add_ons_before_head_tab' );
		if ( $tabs = learning_online_get_add_on_tabs() ) {
			if ( empty( $tabs[$current] ) ) {
				$tab_ids = array_keys( $tabs );
				$current = reset( $tab_ids );
			}
			$links = array();
			foreach ( $tabs as $id => $args ) {
				$class = array();
				if ( !empty( $args['class'] ) ) {
					if ( is_array( $args['class'] ) ) {
						$class = array_merge( $class, $args['class'] );
					} else {
						$class[] = $args['class'];
					}
				}

				$class = join( ' ', $class );
				if ( !empty( $args['url'] ) ) {
					$url = $args['url'];
				} else {
					$url = admin_url( 'admin.php?page=learning-online-addons&tab=' . $id );
				}
				$text = $args['text'];

				$links[] = sprintf( '<li class="%s"><a href="%s" class="%s">%s</a></li>', $class, $url, ( $current == $id ? 'current' : '' ), $text );
			}
			echo join( '|', $links );
		}
		do_action( 'learning_online_add_ons_after_head_tab' );
		?>
	</ul>
    <p class="search-box">
        <input type="text" class="lp-search-addon" value="" placeholder="<?php _e('Search...', 'learningonline'); ?>">
    </p>
	<div class="clear"></div>
        

            <?php do_action( 'learning_online_add_ons_content_tab_' . $current, $current ); ?>

	</div>
	<?php
}
