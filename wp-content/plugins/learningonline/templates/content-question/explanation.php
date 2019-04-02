<?php
/**
 * Template for displaying question's explanation
 *
 * @author  JwsTheme
 * @package LearningOnline/Templates
 * @version 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( !$explanation ) {
	return;
}
?>
<li class="learning-online-question-explanation">
	<strong class="explanation-title"><?php esc_html_e('Explanation:', 'learningonline');?></strong>
	<?php echo do_shortcode( $explanation ); ?>
</li>