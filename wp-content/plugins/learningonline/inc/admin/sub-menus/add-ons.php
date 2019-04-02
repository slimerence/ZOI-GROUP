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
function learning_online_add_ons_page() {
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
					$url = admin_url( 'admin.php?page=learning_online_add_ons&tab=' . $id );
				}
				$text = $args['text'];

				$links[] = sprintf( '<li class="%s"><a href="%s" class="%s">%s</a></li>', $class, $url, ( $current == $id ? 'current' : '' ), $text );
			}
			echo join( '|', $links );
		}
		do_action( 'learning_online_add_ons_after_head_tab' );
		?>
	</ul>
	<div class="clear"></div>

            <?php do_action( 'learning_online_add_ons_content_tab_' . $current, $current ); ?>

            <?php if ( strtolower( $theme->name ) !== 'eduma' ) : ?>
                <div class="theme">
                    <a href="https://themeforest.net/item/education-wordpress-theme-education-wp/14058034?s_rank=3">
                        <img src="https://jwstheme.com/wp-content/uploads/2016/09/01_preview-4.jpg" />
                    </a>
                    <h2><?php _e( 'Looking for an excellent LMS and Education WordPress theme?', 'learningonline' ); ?></h2>
                    <p><?php printf( '%s <strong>%s</strong>', __( 'We recommend Education WP,', 'learningonline' ), __( 'the #1 Best Selling Education Theme of 2016', 'learningonline' ) ); ?></p>
                    <p><?php _e( 'Education WP is completely dedicated to learning with 10+ pre-designed demos and full functionalities for schools, universities, kindergartens, training centers, eLearnings, MOOCS or online courses websites.', 'learningonline' ); ?></p>
                    <p><?php _e( 'It is easy to use and easy to install. Your dream online school is only a few clicks away. It also comes with a bonus package of premium add-ons for LearningOnline LMS that worths 439$+.', 'learningonline' ); ?></p>
                    <p>
                        <a href="https://jwstheme.com/education-wordpress-theme-education-wp/" class="button" target="_blank"><?php _e( 'Read all about it', 'learningonline' ); ?></a>
                        <a href="https://themeforest.net/item/education-wordpress-theme-education-wp/14058034?ref=JwsTheme&utm_source=learningonline&utm_medium=addondashboard" class="button button-primary" target="_blank"><?php _e( 'Get it now for only 64$', 'learningonline' ); ?></a>
                    </p>
                </div>
            <?php endif; ?>
	</div>
	<?php
}
