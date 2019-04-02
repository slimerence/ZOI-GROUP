<?php
/**
 * User Profile tabs
 *
 * @author  JwsTheme
 * @package LearningOnline/Templates
 * @version 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}
$current = learning_online_get_current_profile_tab();
?>
<ul class="tabs learning-online-tabs clearfix">
	<?php foreach ( $tabs as $key => $tab ) : ?>
		<?php
		if ( !learning_online_current_user_can_view_profile_section( $key, $user ) ) {
			continue;
		}
		?>
		<li class="<?php echo esc_attr( $key ); ?>_tab<?php echo $current == $key ? ' current' : ''; ?>">
			<?php
			$link = learning_online_user_profile_link( $user->id, $key );
			?>
			<a href="<?php echo esc_url( $link ); ?>" data-slug="<?php echo esc_attr( $link ); ?>"><?php echo apply_filters( 'learning_online_profile_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?></a>
		</li>
	<?php endforeach; ?>
</ul>
<div class="user-profile-tabs learning-online-tabs-wrapper-x">
	<?php foreach ( $tabs as $key => $tab ) : ?>
		<?php if ( $current == $key && learning_online_current_user_can_view_profile_section( $key, $user ) ) { ?>
			<div class="learning-online-tab" id="tab-<?php echo esc_attr( $key ); ?>">
				<div class="entry-tab-inner">
					<?php if ( is_callable( $tab['callback'] ) ): ?>
						<?php echo call_user_func_array( $tab['callback'], array( $key, $tab, $user ) ); ?>
					<?php endif; ?>
				</div>
			</div>
		<?php } ?>
	<?php endforeach; ?>
</div>
<div class="clearfix"></div>
