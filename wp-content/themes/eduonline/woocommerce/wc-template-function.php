<?php
add_theme_support( 'woocommerce' );

/** Template pages ********************************************************/

if (!function_exists('jws_theme_woocommerce_content')) {
    
    function jws_theme_woocommerce_content() {

        if (is_singular('product')) {
            wc_get_template_part('single', 'product');
        } else {
            wc_get_template_part('archive', 'product');
        }
    }

}
/**
* Change number of related products on product page
* Set your own value for 'posts_per_page'
*/ 
add_filter( 'woocommerce_output_related_products_args', 'jws_theme_related_products_args' );
function jws_theme_related_products_args( $args ) {
    $args['posts_per_page'] = 3; // 4 related products
    $args['columns'] = 3; // arranged in 4 columns
    return $args;
}
/**
* Change number of upsell display products on product page
* Set your own value for 'posts_per_page'
*/ 
function woocommerce_upsell_display( $posts_per_page = 4, $columns = 4, $orderby = 'rand' ) {
	global $tb_options;
	$fullwidth = ( (isset( $_GET['layout']) && $_GET['layout'] ==='fullwidth' ) || ($tb_options['tb_single_sidebar_pos_shop'] ==='tb-sidebar-hidden' ) );
    if (is_active_sidebar('tbtheme-woo-single-sidebar'))
        $columns = 3;
    $template = 'single-product/up-sells.php';
	if( $fullwidth ){
		$columns = $posts_per_page = 4;
		$template = 'single-product/up-sells-carousel.php';
	}
	
	woocommerce_get_template( $template, array(
		'posts_per_page' => $posts_per_page,
		'orderby' => $orderby,
		'columns' => $columns
	) );
}

if ( ! function_exists( 'jws_theme_woocommerce_breadcrumb_defaults' ) ) {

	/**
	 * Output the WooCommerce Breadcrumb
	 *
	 * @access public
	 * @return void
	 */
	function jws_theme_woocommerce_breadcrumb_defaults( $args = array() ) {
		global $jws_theme_options;
		$delimiter = isset($jws_theme_options['jws_theme_page_breadcrumb_delimiter']) ? $jws_theme_options['jws_theme_page_breadcrumb_delimiter'] : '/';
		$args['delimiter']   = '<span>'.$delimiter.'</span>';
		return $args;
	}
}
if ( ! function_exists( 'jws_theme_woocommerce_sharing' ) ) {

	function jws_theme_woocommerce_sharing() {
		global $product;
		$permalink = $product->post->guid;
		$title = $product->post->post_title;
		
		$content = '<!-- Go to www.addthis.com/dashboard to customize your tools -->
					<div class="addthis_sharing_toolbox addthis_default_style"></div>';

		echo $content;
	}
}

/* hook layout woo */
add_action( 'wp_ajax_ct_hook_woo_columns', 'jws_theme_hook_woo_columns' );
add_action( 'wp_ajax_nopriv_ct_hook_woo_columns', 'jws_theme_hook_woo_columns' );

function jws_theme_hook_woo_columns() {
	global $woocommerce_loop;
	$column = $_POST['column'];
	$woocommerce_loop['columns'] = $column;
	delete_option('loop_shop_columns');
	add_option('loop_shop_columns',$column);
	die($column);
}

function jws_theme_sort_by_page($count) {
	global $jws_theme_options;

 $count = 9;
 if (isset($_GET['jws_theme_sortby'])) {
  $count = $_GET['jws_theme_sortby'];
 }elseif( isset( $jws_theme_options['jws_theme_archive_shop_per_page'] ) ){
 	$count = intval( $jws_theme_options['jws_theme_archive_shop_per_page']);
 }
 // else normal page load and no cookie
 return $count;
}
add_filter('loop_shop_per_page','jws_theme_sort_by_page', 15);

/**
 *  Add the link to compare
 */
function jws_theme_add_compare_link( $product_id = false, $args = array() ) {
	extract( $args );

	if ( ! $product_id ) { 
		global $product;
		$product_id = isset( $product->id ) && $product->exists() ? $product->id : 0;
	}

	// return if product doesn't exist
	if ( empty( $product_id ) ) return;
	
	$action_add ='yith-woocompare-add-product';
	$url_args = array(
					'action' => 'yith-woocompare-add-product',
					'id' => $product_id
				);
	$add_product_url = wp_nonce_url( add_query_arg( $url_args ), $action_add );
	printf( '<div class="woocommerce product compare-button"><a href="%s" class="%s" data-product_id="%d" title="%s">%s</a></div>', $add_product_url, 'compare', $product_id, 'Compare', 'Compare' );
}

/**
 * Add quick view button in wc product loop
 */
function jws_theme_add_quick_view_button() {

	global $product;

	echo '<a href="#" class="button yith-wcqv-button" data-product_id="' . $product->id . '"></a>';
}

// rename for tags tab
function jws_theme_woo_rename_tabs( $tabs ) {

	$tabs['tag']['title'] = __( 'Tags', 'eduonline' );

	return $tabs;
}

// change related products args
function jws_theme_woo_related_products_args( $args ) {
	$args['posts_per_page'] = 4;
	$args['columns'] = 4;
	return $args;
}

// change rating output

// function jws_theme_woo_get_rating_html( $rating_html, $rating ){
// 	$rating_html = str_replace( '<div>', '</div>', $rating_html );
// 	return $rating_html;
// }
// Add term page
add_action( 'product_cat_add_form_fields', 'jws_theme_taxonomy_add_new_meta_field', 10, 2 );
function jws_theme_taxonomy_add_new_meta_field() {
  ?>
  <div class="form-field">
    <label for="term_meta[jws_theme_full_width]"><?php _e( 'Show as full width', 'eduonline' ); ?></label>
   <select name="term_meta[jws_theme_full_width]" id="term_meta[jws_theme_full_width]">
		<option value="0"><?php esc_html_e('No','eduonline');?></option>
	   <option value="1"><?php esc_html_e('Yes','eduonline');?></option>
		</select>
  </div>
  <?php
}


// Edit term page
add_action( 'product_cat_edit_form_fields', 'jws_theme_taxonomy_edit_meta_field', 10, 2 );
function jws_theme_taxonomy_edit_meta_field($term) {
 
  // put the term ID into a variable
  $t_id = $term->term_id;
 
  // retrieve the existing value(s) for this meta field. This returns an array
  $term_meta = get_option( "taxonomy_$t_id" );
  $jws_theme_full_wid = $term_meta['jws_theme_full_width'] ? intval( $term_meta['jws_theme_full_width'] ) : 0;
  ?>
  <tr class="form-field">
  <th scope="row" valign="top"><label for="term_meta[jws_theme_full_width]"><?php _e( 'Full width', 'eduonline' ); ?></label></th>
    <td>
      <select name="term_meta[jws_theme_full_width]" id="term_meta[jws_theme_full_width]">
		<option <?php selected( $jws_theme_full_wid, 0 );?> value="0"><?php esc_html_e('No','eduonline');?></option>
	   <option <?php selected( $jws_theme_full_wid, 1 );?> value="1"><?php esc_html_e('Yes','eduonline');?></option>
		</select>
    </td>
  </tr>
<?php
}

// Save extra taxonomy fields callback function
add_action( 'edited_product_cat', 'jws_theme_save_taxonomy_custom_meta', 10, 2 );  
add_action( 'create_product_cat', 'jws_theme_save_taxonomy_custom_meta', 10, 2 );
function jws_theme_save_taxonomy_custom_meta( $term_id ) {
  if ( isset( $_POST['term_meta'] ) ) {
    $t_id = $term_id;
    $term_meta = get_option( "taxonomy_$t_id" );
    $cat_keys = array_keys( $_POST['term_meta'] );
    foreach ( $cat_keys as $key ) {
      if ( isset ( $_POST['term_meta'][$key] ) ) {
        $term_meta[$key] = wp_kses_post( stripslashes($_POST['term_meta'][$key]) );
      }
    }
    // Save the option array.
    update_option( "taxonomy_$t_id", $term_meta );
  }
}

function jws_theme_get_op_full_wid(){
	if( isset( $_GET['layout'] ) && $_GET['layout']=='fullwidth' ) return true;
	global $jws_theme_options;
	$t_id = get_queried_object_id();
	$term_meta = get_option( "taxonomy_$t_id" );
	if( isset(  $term_meta['jws_theme_full_width'] ) )
		return $term_meta['jws_theme_full_width'];
	elseif( $jws_theme_options['jws_theme_archive_sidebar_pos_shop'] == 'tb-sidebar-hidden' )
		return true;
}

add_filter('woocommerce_product_single_add_to_cart_text', 'jws_theme_variable_single_add_to_cart_text');
function jws_theme_variable_single_add_to_cart_text( $text ){
	global $product;
	if( $product->is_type( 'variable' ) ){
		$text = __('Select options', 'eduonline');
	}
	return $text;
}

add_action('wp_head','hook_css');

function hook_css() {
	$colors = get_terms('pa_color', array('hide_empty'=>0));
	if( is_wp_error( $colors ) || empty( $colors ) ) return;
	ob_start();
	?>
	<style>
	<?php foreach( $colors as $color ){
		$c = esc_attr( strtolower( $color->name ) );
		?>
		.tb-attribute-<?php echo $c;?>{
			background-color:<?php echo $c;?>;
		}
		<?php
	}
	?>
	</style>
	<?php

	echo ob_get_clean();
}


function jws_theme_get_shop_id( $id, $global ){
	global $jws_theme_options;

	if( is_archive() || is_search() || is_product() ){

		if( isset( $jws_theme_options[ $id ] ) && ! is_shop() ){
			return $jws_theme_options[ $id ];
		}else{
			$post_id = get_option( 'woocommerce_shop_page_id' );
		}
	}else{
		$post_id = get_queried_object_id();
	}

	$result = get_post_meta( $post_id , $id, true );

	if( $global && $result=='global' && isset( $jws_theme_options[ $id ] ) ){
		return $jws_theme_options[ $id ];
	}
	return $result;
	
}

function jws_theme_product_featured_video(){
	global $jws_theme_options, $post;
	if( isset( $jws_theme_options['jws_theme_video_tab'] ) && $jws_theme_options['jws_theme_video_tab']=='on_thumbnail' ){
		$video = get_post_meta($post->ID, 'jws_theme_product_video_youtube', true);
		if( $video ){
			echo '<a class="product-video-popup"  data-toggle="tooltip" data-placement="top" title="'. __("View video","eduonline") .'" href="'. esc_url($video) .'"><span class="fa fa-play"></span>'. __("Play Video","eduonline") .'</a>';
		}
	}
}

// update porfolio
add_action( 'wp_ajax_jws_theme_load_more_products', 'jws_theme_load_more_products' );
add_action( 'wp_ajax_nopriv_jws_theme_load_more_products', 'jws_theme_load_more_products' );

function jws_theme_load_more_products(){
	global $wpdb, $pagenow;
	$data = (array)$_POST['data'];
	if( empty( $data['args']) || empty( $data['atts']) ) return;
	$query_args = (array)$data['args'];

	if( empty( $query_args['paged'] ) ) return;

	$query_args['paged'] += 1;

	$atts =  wp_parse_args( (array)$data['atts'], array(
		'product_cat'       	=> '',
        'show'              	=> 'all_products',
        'number'            	=> -1,
        'hide_free'         	=> 0,
        'show_hidden'       	=> 0,
		'orderby'           	=> 'none',
        'order'             	=> 'none',
		'tpl'					=> 'tpl1',
		'columns'				=> 4,
		'show_pagination' 		=> 0,
		'align_pagination' 		=> 'text-center',
		'el_class' 				=> '',
		'show_sale_flash'       => 0,
		'show_title'        	=> 0,
        'show_price'        	=> 0,
        'show_rating'        	=> 0,
        'show_add_to_cart'      => 0,
        'show_quick_view'      	=> 0,
        'show_whishlist'      	=> 0,
        'show_compare'      	=> 0,
        'show_view_more'        => 0
    ) );
	extract( $atts );

	$class_columns = array();
	switch ($columns) {
		case 1:
			$class_columns[] = 'tb-product-item tb-woo-one-column col-xs-12 col-sm-12 col-md-12 col-lg-12';
			break;
		case 2:
			$class_columns[] = 'col-xs-12 col-sm-6 col-md-6 col-lg-6';
			break;
		case 3:
			$class_columns[] = 'col-xs-12 col-sm-6 col-md-4 col-lg-4';
			break;
		case 4:
			$class_columns[] = 'col-xs-12 col-sm-6 col-md-3 col-lg-3';
			break;
        case 5:
            $class_columns[] = "col-lg-20 col-md-3 col-sm-6 col-xs-12";
            break;
		default:
			$class_columns[] = 'col-xs-12 col-sm-6 col-md-3 col-lg-3';
			break;
	}

	$wpp = new WP_Query( $query_args );
	ob_start();	
	if ($wpp->have_posts() ) {
		$response['args'] = $query_args;
		if( $wpp->max_num_pages > 1 && $query_args['paged'] <= $wpp->max_num_pages ){
			if( $show_pagination ){
				$big = 999999999;
				$response['page'] = paginate_links( array(
						'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						'format' => '?paged=%#%',
						'current' => max( 1, $query_args['paged'] ),
						'total' =>$wpp->max_num_pages,
						'prev_text' => __( '<i class="fa fa-angle-left"></i>', 'eduonline' ),
						'next_text' => __( '<i class="fa fa-angle-right"></i>', 'eduonline' ),
					) );
			}
			
			$response['max'] = $query_args['paged'] == $wpp->max_num_pages;
		}
        $i = 0;
    ?><?php
		while ($wpp->have_posts() ) {$wpp->the_post();
            if( $i==0 && $tpl=='tpl3' ){
                ?>
                    <div class="col-xs-12 col-sm-6">
                    
                        <?php include JWS_THEME_ABS_PATH_FR .'/shortcodes/product_grid/'. $tpl .'.php'; ?>
                        
                    </div>
                <?php
                $tpl = 'tpl2';
            }else{
			?>
				<div class="<?php echo esc_attr(implode(' ', $class_columns)) ?>">
				
					<?php include JWS_THEME_ABS_PATH_FR .'/shortcodes/product_grid/'. $tpl .'.php'; ?>
					
				</div>
			<?php
            }
            $i++;
		}
    }
    wp_reset_postdata();
    $response['content'] = ob_get_clean();
    echo json_encode( $response );
	wp_die();
}

function jws_theme_woocommerce_sortby_page( $options ){
	global $jws_theme_options;
	if( isset( $jws_theme_options['jws_theme_archive_shop_per_page']) && $no_page = (int)$jws_theme_options['jws_theme_archive_shop_per_page']){
		if( !isset( $options[ $no_page ])){
			$options[ $no_page ] = $no_page;
		}
	}

	return $options;
}

function jws_theme_woocommerce_no_page( $page ){
	global $jws_theme_options;
	if( isset( $jws_theme_options['jws_theme_archive_shop_per_page']) && $no_page = (int)$jws_theme_options['jws_theme_archive_shop_per_page'] ){
		$page = $no_page;
	}
	return $page;
}