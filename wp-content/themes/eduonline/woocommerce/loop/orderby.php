<?php
/**
 * Show options for ordering
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<form class="woocommerce-ordering" method="get">
	<?php if( ! isset( $_GET['columns'] ) ){?>
		<input type="hidden" disabled name="columns" value="1">
	<?php } ?>
	<div class="tb-woo-short-by hidden-sm hidden-xs">
		<span><?php _e('Short by: ','eduonline');?></span>
		<select name="orderby" class="orderby">
			<?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
				<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
			<?php endforeach; ?>
		</select>
	</div>
	<div class="tb-woo-sort-by  hidden-sm hidden-xs">
		<span><?php _e('Show: ','eduonline');?></span>
		<select name="jws_theme_sortby" id="jws_theme_sortby" class="jws_theme_sortby" onchange="this.form.submit()">
			<?php		 
			//Get products on page reload
			if  (isset($_GET['jws_theme_sortby'])) :
				$numberOfProductsPerPage = $_GET['jws_theme_sortby'];
			else:
				$numberOfProductsPerPage = apply_filters('jws_theme_woocommerce_no_page', 9);
			endif;
			$shopCatalog_orderby = apply_filters('jws_theme_woocommerce_sortby_page', array(
				'3' 		=> __('3', 'eduonline'),
				'6' 		=> __('6', 'eduonline'),
				'9' 		=> __('9', 'eduonline'),
				'12' 		=> __('12', 'eduonline'),
				'15' 		=> __('15', 'eduonline'),
				'18' 		=> __('18', 'eduonline'),
				'-1' 		=> __('All', 'eduonline'),
			));

			foreach ( $shopCatalog_orderby as $sort_id => $sort_name )
				echo '<option value="' . $sort_id . '" ' . selected( $numberOfProductsPerPage, $sort_id, true ) . ' >' . $sort_name . '</option>';
			?>
		</select>
	</div>
	<?php
		// Keep query string vars intact
		foreach ( $_GET as $key => $val ) {
			if ( 'orderby' === $key || 'submit' === $key  || 'jws_theme_sortby' === $key ) {
				continue;
			}
			if ( is_array( $val ) ) {
				foreach( $val as $innerVal ) {
					echo '<input type="hidden" name="' . esc_attr( $key ) . '[]" value="' . esc_attr( $innerVal ) . '" />';
				}
			} else {
				echo '<input type="hidden" name="' . esc_attr( $key ) . '" value="' . esc_attr( $val ) . '" />';
			}
		}
	?>
</form>
