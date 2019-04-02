<?php
/**
 * @author        JwsTheme
 * @package       LearningOnline/Templates
 * @version       2.1.4.2
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<h2><?php _e( 'Order Details', 'learningonline' ); ?></h2>
<table class="order_table order_details">
	<thead>
	<tr>
		<th class="course-name"><?php _e( 'Course', 'learningonline' ); ?></th>
		<th class="course-total"><?php _e( 'Total', 'learningonline' ); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php
	if ( $items = $order->get_items() ) {
		$currency_symbol = learning_online_get_currency_symbol( $order->order_currency );

		foreach ( $items as $item_id => $item ) {
			//$_course  = apply_filters( 'learning_online_order_item_course', get_post( $item_id ), $item );
			if ( apply_filters( 'learning_online_order_item_visible', true, $item ) ) {
				$course = learning_online_get_course( $item['course_id'] );
				if ( !$course->exists() ) {
					continue;
				}
				?>
				<tr class="<?php echo esc_attr( apply_filters( 'learning_online_order_item_class', 'order_item', $item, $order ) ); ?>">
					<td class="course-name">
						<?php
						echo apply_filters( 'learning_online_order_item_name', sprintf( '<a href="%s">%s</a>', get_permalink( $item['course_id'] ), $item['name'] ), $item );
						?>
					</td>
					<td class="course-total">
						<?php
						if ( $price = $course->get_price_html() ) {
							$origin_price = $course->get_origin_price_html();
							if ( $course->get_sale_price() !== ''/* $price != $origin_price */ ) {
								echo '<span class="course-origin-price">' . $origin_price . '</span>';
							}
							echo '<span class="course-price">' . $price . '</span>';
						}
						?>
						<?// echo !empty( $item['total'] ) ? learning_online_format_price( $item['total'], $currency_symbol ) : __( 'Free!', 'learningonline' ); ?>
					</td>
				</tr>
				<?php
			}
		}
	}
	do_action( 'learning_online_order_items_table', $order );
	?>
	</tbody>
	<tfoot>

	<tr>
		<th scope="row"><?php _e( 'Subtotal', 'learningonline' ); ?></th>
		<td><?php echo $order->get_formatted_order_subtotal(); ?></td>
	</tr>
	<tr>
		<th scope="row"><?php _e( 'Total', 'learningonline' ); ?></th>
		<td><?php echo $order->get_formatted_order_total(); ?></td>
	</tr>
	</tfoot>
</table>

<?php do_action( 'learning_online_order_details_after_order_table', $order ); ?>

<div class="clear"></div>
