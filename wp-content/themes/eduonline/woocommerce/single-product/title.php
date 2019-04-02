<?php
/**
 * Single Product title
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>
<div itemprop="name" class="entry-title"><?php the_title(); ?>
	<div class="text-right nav-product-link">
		<?php
		previous_post_link('%link','<i class="fa fa-angle-left"></i>');
		next_post_link('%link','<i class="fa fa-angle-right"></i>');
		?>
	</div>
</div>