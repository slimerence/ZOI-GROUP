<?php
/**
 *
 */
?>
<tr data-item_id="<?php echo $item['id']; ?>" data-remove_nonce="<?php echo wp_create_nonce( 'remove_order_item' ); ?>">
	<td>
		<?php do_action('learning_online_before_order_details_item_title', $item);?>
        <?php do_action('learning_online/before_order_details_item_title', $item);?>
		<a href="" class="remove-order-item">&times;</a>
		<a href="<?php echo get_the_permalink( $item['course_id'] ); ?>"><?php echo $item['name']; ?></a>
		<?php do_action('learning_online_after_order_details_item_title', $item);?>
	</td>
		<?php do_action('learning_online/after_order_details_item_title', $item);?>
    </td>
	<td class="align-right">
		<?php echo learning_online_format_price( $item['total'], $currency_symbol ); ?>
	</td>
	<td class="align-right"><?php echo $item['quantity']; ?></td>
	<td class="align-right"><?php echo learning_online_format_price( $item['total'], $currency_symbol ); ?></td>
</tr>
