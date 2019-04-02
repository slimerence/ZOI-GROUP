<?php
/**
 * @author  JwsTheme
 * @package LearningOnline/Templates
 * @version 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

$comment_heading = apply_filters( 'learning_online_order_comment_heading', __( 'Additional Information', 'learningonline' ) );

?>

<div class="learning-online-checkout-comment">

	<?php if ( $comment_heading ) { ?>

		<h3 class="learning-online-order-comment-heading"><?php echo $comment_heading; ?></h3>

	<?php } ?>
	<textarea name="order_comments"></textarea>

</div>
