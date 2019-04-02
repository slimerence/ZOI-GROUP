<?php
/**
 * @author  JwsTheme
 * @package LearningOnline/Templates
 * @version 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( !$order->get_items() ) {
	return;
}
?>
<table cellspacing="0" cellpadding="5" style="width: 100%; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;" border="1">
	<thead>
	<tr>
		<th class="td" scope="col" style="text-align:left;"><?php _e( 'Course', 'learningonline' ); ?></th>
		<th class="td" scope="col" style="text-align:left;"><?php _e( 'Quantity', 'learningonline' ); ?></th>
		<th class="td" scope="col" style="text-align:left;"><?php _e( 'Price', 'learningonline' ); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ( $order->get_items() as $item_id => $item ):

		$course = apply_filters( 'learning_online_order_item_course', learning_online_get_course( $item['course_id'] ), $item );

		?>
		<tr>
			<?php do_action( 'learning_online_before_order_item', $item_id, $item, $order ); ?>
			<td style="text-align:left; vertical-align:middle; border: 1px solid #eee; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;">
				<?php echo apply_filters( 'learning_online_order_item_name', $item['name'], $item ); ?>
			</td>
			<td style="text-align:left; vertical-align:middle; border: 1px solid #eee; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;">
				<?php echo "\n" . sprintf( __( 'Quantity: %s', 'learningonline' ), apply_filters( 'learning_online_email_order_item_quantity', $item['quantity'], $item ) ); ?>
			</td>
			<td style="text-align:left; vertical-align:middle; border: 1px solid #eee; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;">
				<?php echo "\n" . sprintf( __( 'Cost: %s', 'learningonline' ), apply_filters( 'learning_online_email_order_item_cost', learning_online_format_price( $item['total'] ), $item ) ); ?>
			</td>
			<?php do_action( 'learning_online_after_order_item', $item_id, $item, $order ); ?>
		</tr>

	<?php endforeach; ?>
	</tbody>
</table>