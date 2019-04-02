<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */
if (!defined('ABSPATH')) exit; // Exit if accessed directly
global $woocommerce_loop;
$jws_theme_options = $GLOBALS['jws_theme_options'];

// Store column count for displaying the grid
$is_full_wid = jws_theme_get_op_full_wid();
if( isset( $_GET['columns'] ) ){
	$woocommerce_loop['columns'] = intval( $_GET['columns'] );
}else{
	if( $is_full_wid  ){
		$woocommerce_loop['columns'] = isset( $jws_theme_options['jws_theme_archive_shop_ful_column'] ) ?  (int)$jws_theme_options['jws_theme_archive_shop_ful_column'] : 4;
	}elseif ( empty( $woocommerce_loop['columns'] ) ) {
		$columns = isset( $jws_theme_options['jws_theme_archive_shop_column'] ) ?  (int)$jws_theme_options['jws_theme_archive_shop_column'] : 4;
		$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', $columns );
	}
}

get_header();
?>
<?php

	$cl_content = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
	$cl_sidebar = '';

	if ( ! $is_full_wid && is_active_sidebar('tbtheme-woo-shop-sidebar') ) {
		$cl_content = 'col-xs-12 col-sm-8 col-md-8 col-lg-9 tb-content';
		$cl_sidebar = 'col-xs-12 col-sm-4 col-md-4 col-lg-3 sidebar-area';
	}

	$is_one_col = $woocommerce_loop['columns'] == 1;
	if( isset( $_GET['sidebar'] ) ){
		$jws_theme_sidebar_pos =  trim( $_GET['sidebar'] );
		$jws_theme_sidebar_pos = $jws_theme_sidebar_pos == 'tb-sidebar-left' ? $jws_theme_sidebar_pos : 'tb-sidebar-right'; 
	}else{
		$jws_theme_sidebar_pos = ! empty($jws_theme_options['jws_theme_archive_sidebar_pos_shop'])?$jws_theme_options['jws_theme_archive_sidebar_pos_shop']:'tb-sidebar-right';
	}
	


?>
<div class="archive-products<?php if( $is_full_wid ) echo ' grid-full-width';?>">
	<div class="container">
		<div class="row <?php echo esc_attr($jws_theme_sidebar_pos); ?>">

			<?php if ( ! $is_full_wid && $jws_theme_sidebar_pos == 'tb-sidebar-left') { ?>
				<div class="<?php echo esc_attr($cl_sidebar); ?>">
					<div id="secondary" class="widget-area" role="complementary">
						<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
							<?php
								if(is_active_sidebar('tbtheme-woo-shop-sidebar')){
									dynamic_sidebar( 'tbtheme-woo-shop-sidebar' ); 
								}
							?>
						</div>
					</div>
				</div>
			<?php } ?>
			
			<div class="<?php echo esc_attr($cl_content); ?>">
				
				<?php do_action('woocommerce_archive_description'); ?>

				<?php if (have_posts()) : ?>
					
					<div class="tb-start-shop-loop<?php if( $is_full_wid ) echo ' tb-shop-topbar-full'; ?>">
						<!-- View as -->
						<div class="tb-view-as">
							<p class="woocommerce-result-count">
								<span><?php _e('View as:', 'eduonline')?></span>
								<a href="javascript:void(0);" title="Layout Grid" data-column="3" class="jws_theme_action_grid jws_theme_action_layout jws_theme_action <?php if( ! $is_one_col ){ echo 'active'; }?>"><i class="fa fa-th"></i></a>
								<a href="javascript:void(0);" title="Layout List" data-column="1" class="jws_theme_action_list jws_theme_action_layout jws_theme_action <?php if( $is_one_col ){ echo 'active'; }?>"><i class="fa fa-list"></i></a>
							</p>
						</div>
						
						<!-- Catalog Ordering-->
						<div class="tb-shop-catalog-ordering">
							<?php if($jws_theme_options['jws_theme_archive_show_catalog_ordering']) woocommerce_catalog_ordering(); ?>
						</div>



						<!-- extra attributes filter -->
						<?php if( $is_full_wid ):?>
							<div class="pull-right tb-shop-attribute">
								<?php if( is_active_sidebar('tbtheme-woo-archive-attr-sidebar') ) dynamic_sidebar( 'tbtheme-woo-archive-attr-sidebar' ); ?>
							</div>
						<?php endif; ?>

					</div>
					
					<?php woocommerce_product_loop_start(); ?>

					<?php woocommerce_product_subcategories(); ?>

					<?php while (have_posts()) : the_post(); ?>

						<?php wc_get_template_part('content', 'product'); ?>

					<?php endwhile;wp_reset_postdata(); ?>

					<?php woocommerce_product_loop_end(); ?>
					
					<div class="tb-after-shop-loop">
					
						<!-- View as -->
						<div class="tb-view-as">
							<p class="woocommerce-result-count">
								<span><?php _e('View as:', 'eduonline')?></span>
								<a href="#" title="Layout Grid" data-column="3" class="jws_theme_action_grid jws_theme_action <?php if( ! $is_one_col ){ echo 'active'; }?>"><i class="fa fa-th"></i></a>
								<a href="#" title="Layout List" data-column="1" class="jws_theme_action_list jws_theme_action <?php if( $is_one_col ){ echo 'active'; }?>"><i class="fa fa-list"></i></a>
							</p>
						</div>
						
						<!-- Pagination -->
						<div class="tb-shop-pagination pull-right">
							<?php
							/**
							 * woocommerce_after_shop_loop hook
							 *
							 * @hooked woocommerce_pagination - 10
							 */
							if($jws_theme_options['jws_theme_archive_show_pagination_shop']) do_action('woocommerce_after_shop_loop');
							?>
						</div>
					</div>

				<?php elseif (!woocommerce_product_subcategories(array('before' => woocommerce_product_loop_start(false), 'after' => woocommerce_product_loop_end(false)))) : ?>

					<?php wc_get_template('loop/no-products-found.php'); ?>

				<?php endif; ?>

			</div>
			<?php if ( ! $is_full_wid && $jws_theme_sidebar_pos == 'tb-sidebar-right') { ?>
				<div class="<?php echo esc_attr($cl_sidebar); ?>">
					<div id="secondary" class="widget-area" role="complementary">
						<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
							<?php
								if(is_active_sidebar('tbtheme-woo-shop-sidebar')){
									dynamic_sidebar( 'tbtheme-woo-shop-sidebar' ); 
								}
							?>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
</div>

<?php get_footer(); ?>
