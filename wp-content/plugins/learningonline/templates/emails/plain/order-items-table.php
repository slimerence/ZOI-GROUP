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

foreach ( $order->get_items() as $item_id => $item ):

	$course = apply_filters( 'learning_online_order_item_course', learning_online_get_course( $item['course_id'] ), $item );

	echo apply_filters( 'learning_online_order_item_name', $item['name'], $item );

	do_action( 'learning_online_before_order_item', $item_id, $item, $order );

	echo "\n" . sprintf( __( 'Quantity: %s', 'learningonline' ), apply_filters( 'learning_online_email_order_item_quantity', $item['quantity'], $item ) );

	echo "\n" . sprintf( __( 'Cost: %s', 'learningonline' ), apply_filters( 'learning_online_email_order_item_cost', learning_online_format_price( $item['total'] ), $item ) );

	do_action( 'learning_online_after_order_item', $item_id, $item, $order );

	echo "\n\n";

endforeach;