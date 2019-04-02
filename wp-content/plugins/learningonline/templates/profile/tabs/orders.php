<?php
/**
 * Template for displaying user's orders
 *
 * @author  JwsTheme
 * @package LearningOnline/Template
 * @version x.x
 */
defined( 'ABSPATH' ) || exit();

$user_id = learning_online_get_current_user_id();
$page    = get_query_var( 'paged', 1 );
$limit   = 10;

if ( $orders = _learning_online_get_user_profile_orders( $user_id, $page, $limit ) ):
	if ( empty( $orders['rows'] ) ) {
		$orders['rows'] = array();
	}
	if ( $orders['rows'] ) :
		?>
		<table class="table-orders">
			<thead>
			<th><?php _e( 'Order', 'learningonline' ); ?></th>
			<th><?php _e( 'Date', 'learningonline' ); ?></th>
			<th><?php _e( 'Status', 'learningonline' ); ?></th>
			<th><?php _e( 'Total', 'learningonline' ); ?></th>
			<th><?php _e( 'Action', 'learningonline' ); ?></th>
			</thead>
			<tbody>
			<?php foreach ( $orders['rows'] as $order ): $order = learning_online_get_order( $order ); ?>
				<tr>
					<td><?php echo $order->get_order_number(); ?></td>
					<td><?php echo date_i18n( get_option( 'date_format' ), strtotime( $order->order_date ) ); ?></td>
					<td>
						<?php echo $order->get_order_status_html(); ?>
						<?php
						if ( $order->has_status( 'pending' ) ) :
							printf( '(<small><a href="%s" class="%s">%s</a></small>)', $order->get_cancel_order_url(), 'cancel-order', __( 'Cancel', 'learningonline' ) );
						endif;
						?>
					</td>
					<td><?php echo $order->get_formatted_order_total(); ?></td>
					<td>
						<?php
						$actions['view'] = array(
							'url'  => $order->get_view_order_url(),
							'text' => __( 'View', 'learningonline' )
						);
						$actions         = apply_filters( 'learning_online_user_profile_order_actions', $actions, $order );

						foreach ( $actions as $slug => $option ) {
							printf( '<a href="%s">%s</a>', $option['url'], $option['text'] );
						}
						?>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>

		<?php
		learning_online_paging_nav( array(
			'num_pages' => $orders['num_pages'],
			'base'      => learning_online_user_profile_link( $user_id, LP()->settings->get( 'profile_endpoints.profile-orders' ) )
		) );
		?>

	<?php else: ?>
		<?php learning_online_display_message( __( 'You have not got any orders yet!', 'learningonline' ) ); ?>
	<?php endif; ?>

<?php else: ?>
	<?php learning_online_display_message( __( 'You have not got any orders yet!', 'learningonline' ) ); ?>
<?php endif; ?>
