<?php
function tb_search_course($atts) {
    $atts=shortcode_atts(array(
        'title' => '',
        'sub_title' => '',
        'show_textbox' => 1,
        'show_category' => 1,
        'show_degree' => 1,
        'el_class' => ''
    ), $atts);
	extract($atts);

    $class[] = $el_class;
        
    $args = array(
		'posts_per_page' => -1,
        'post_type' => 'lp_course',
        'post_status' => 'publish');
	
    $argss = array(
		'orderby'    => 'title',
		'order'      => 'ASC',
		'exclude'    => 1,//remove uncategory
		'hide_empty' => true,
    );
	
	$course_categories = get_terms( 'course_category', $argss );
    $count = count($course_categories);

    $wp_query = new WP_Query($args);
	$degrees = array();
    ob_start();
    if ( $wp_query->have_posts() ) {
		
		while ( $wp_query->have_posts() ) { $wp_query->the_post();
			$meta = get_post_meta(get_the_ID(), '_lp_degree', true);
			if(!empty($meta)){
				$degrees[] = $meta;
			}
		}
	}
	?>
	
		<div class="search-course-container">
			<div class="tb-search-heading">	
				<div class="tb-heading-content">	
					<h4><?php echo esc_attr($title); ?></h4>
					<p><?php echo esc_attr($sub_title); ?></p>
				</div>
			</div>
			<form role="search" method="get" class="search-course" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<ul class="search-fields list-inline">
					<li class="field-meta-search <?php if(! $show_textbox) echo 'hidden'; ?>">
						<input type="search" id="search-course-<?php echo isset( $index ) ? absint( $index ) : 0; ?>" class="search-field" placeholder="<?php echo esc_attr__( 'Search course&hellip;', 'eduonline' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
						<input type="hidden" name="ref" value="course" />
					</li>
					<li class="field-meta-degree <?php if(! $show_degree) echo 'hidden'; ?>">
						<select name="degree">
							<option value=""><?php echo _e('Select a Degree','eduonline');?></option>
							<?php foreach(array_unique($degrees) as $degree) {
								echo '<option value="' . $degree . '">' . $degree . '</option>';
							}
						?>
						</select>
					</li>
					<li class="field-meta-category <?php if(! $show_category) echo 'hidden'; ?>">
						<select name= "cate">
							<option value=""><?php echo _e('Select a Category','eduonline');?></option>
							<?php
							   if ( $count > 0 ){
								foreach ( $course_categories as $course_categories ) {
									?>
									<option value="<?php echo esc_attr( $course_categories->slug );?>">
											<?php echo esc_attr( $course_categories->name); ?>
									</option>
									<?php
								}
							}
							?>
						</select>
					</li>
					<li class="button">
						<input type="submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'eduonline' ); ?>" />
					</li>
				</ul>
			</form>

		</div>		
    <?php
	
    wp_reset_postdata();
    return ob_get_clean();
}

if(function_exists('insert_shortcode')) { insert_shortcode('search_course', 'tb_search_course'); }
