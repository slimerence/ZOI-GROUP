<?php
/**
 * Template for displaying all notices from queue
 *
 * @author  JwsTheme
 * @package LearningOnline/Templates
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! $notices ){
	return;
}

?>

<ul class="learning-online-error">
	<?php foreach ( $notices as $notice ) : ?>
	<li><?php echo wp_kses_post( $notice ); ?></li>
	<?php endforeach; ?>
</ul>
