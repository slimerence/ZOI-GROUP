<?php
$tabs = apply_filters( 'learning_online_course_tabs', array() );
if ( !empty( $tabs ) ) : ?>
	<?php
	$index        = 0;
	$active_index = - 1;

	foreach ( $tabs as $key => $tab ) {
		if ( !empty( $tab['active'] ) && $tab['active'] == true ) {
			$active_index = $index;
		}
		$index ++;
	}

	if ( $active_index == - 1 ) {
		$active_index = 0;
	}
	$index = 0;

	?>
	<div class="learning-online-tabs learning-online-tabs-wrapper">
		<ul class="learning-online-nav-tabs">
			<?php foreach ( $tabs as $key => $tab ) : ?>
				<?php
				$unikey            = uniqid( $key . '-' );
				$tabs[$key]['key'] = $unikey;
				?>
				<li class="learning-online-nav-tab learning-online-nav-tab-<?php echo esc_attr( $key ); ?><?php echo $index++ == $active_index ? ' active' : ''; ?>" data-tab="<?php echo esc_attr( $key ); ?>">
					<a href="" data-tab="#tab-<?php echo esc_attr( $unikey ); ?>"><?php echo apply_filters( 'learning_online_course_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?></a>
				</li>
			<?php endforeach; ?>
		</ul>
		<?php $index = 0; ?>
		<?php foreach ( $tabs as $key => $tab ) : ?>
			<div class="learning-online-tab-panel learning-online-tab-panel-<?php echo esc_attr( $key ); ?> panel learning-online-tab<?php echo $index ++ == $active_index ? ' active' : ''; ?>" id="tab-<?php echo esc_attr( $tab['key'] ); ?>">
                                <?php if ( apply_filters( 'learning_online_allow_display_tab_section', true, $key, $tab ) ) : ?>
                                    <?php call_user_func( $tab['callback'], $key, $tab ); ?>
                                <?php endif; ?>
			</div>
		<?php endforeach; ?>
	</div>

<?php endif; ?>