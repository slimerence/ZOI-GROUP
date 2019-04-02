<?php
$jws_theme_options = $GLOBALS['jws_theme_options'];

$jws_theme_classes_crop_image = isset($jws_theme_options['jws_theme_classes_crop_image']) ? $jws_theme_options['jws_theme_classes_crop_image'] : 0;
$jws_theme_classes_image_width = (int) isset($jws_theme_options['jws_theme_classes_image_width']) ? $jws_theme_options['jws_theme_classes_image_width'] : 800;
$jws_theme_classes_image_height = (int) isset($jws_theme_options['jws_theme_classes_image_height']) ? $jws_theme_options['jws_theme_classes_image_height'] : 400;
$jws_theme_classes_show_title = (int) isset($jws_theme_options['jws_theme_classes_show_title']) ? $jws_theme_options['jws_theme_classes_show_title'] : 1;
$jws_theme_classes_show_content = (int) isset($jws_theme_options['jws_theme_classes_show_content']) ? $jws_theme_options['jws_theme_classes_show_content'] : 1;
$jws_theme_classes_content_length = (int) isset($jws_theme_options['jws_theme_classes_content_length']) ? $jws_theme_options['jws_theme_classes_content_length'] : -1;

$jws_theme_classes_content_more = (int) isset($jws_theme_options['jws_theme_classes_content_more']) ? $jws_theme_options['jws_theme_classes_content_more'] : '';

$jws_theme_classes_show_button_price = (int) isset($jws_theme_options['jws_theme_classes_show_button_price']) ? $jws_theme_options['jws_theme_classes_show_button_price'] : -1;

$jws_theme_classes_url_price = (int) isset($jws_theme_options['jws_theme_classes_url_price']) ? $jws_theme_options['jws_theme_classes_url_price'] : '';

$jws_theme_classes_show_button_register = (int) isset($jws_theme_options['jws_theme_classes_show_button_register']) ? $jws_theme_options['jws_theme_classes_show_button_register'] : -1;

$jws_theme_classes_url_register = (int) isset($jws_theme_options['jws_theme_classes_url_register']) ? $jws_theme_options['jws_theme_classes_url_register'] : '';




?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="tb-post-item">
		<div class="row">
			<div class="col-md-6 col-sm-12 col-sx-12">
				<div class="tb-content tb-content-single-fwd">
					<?php if($jws_theme_classes_show_title) { ?>
						<a href="<?php the_permalink(); ?>"><h3 class="tb-title"><?php the_title(); ?></h3></a>
					<?php }?>	
					<?php if($jws_theme_classes_show_content) echo jws_theme_custom_content( intval( $jws_theme_classes_content_length ),$jws_theme_classes_content_more); ?>
				</div>
				
				<?php
				$year_olds = esc_attr( get_post_meta(get_the_ID(), 'jws_theme_year_olds', true) );
				$class_size = esc_attr( get_post_meta(get_the_ID(), 'jws_theme_classes_size', true) );
				$member = esc_attr( get_post_meta(get_the_ID(), 'jws_theme_member_hours', true) );
				$start_date = esc_attr( get_post_meta(get_the_ID(), 'jws_theme_start_date', true) );
				$class_duration = esc_attr( get_post_meta(get_the_ID(), 'jws_theme_class_duration', true) );
				$transportation = esc_attr( get_post_meta(get_the_ID(), 'jws_theme_transportation', true) );
				$class_staff = esc_attr( get_post_meta(get_the_ID(), 'jws_theme_class_staff', true) );
				$class_price_per_day = esc_attr( get_post_meta(get_the_ID(), 'jws_theme_class_price', true) );
				
				?>
				<div class="tb-classes-table jws_theme_classes_widget">
				<div class="classes-meta-item">
					<i class="fa fa-calendar"></i>
					<div class="classes-meta-item-content">
						<?php echo esc_html__('Start date','prechool'); ?>
						<span><?php echo $start_date; ?></span>
					</div>
				</div>
				<div class="classes-meta-item">
					<i class="fa fa-birthday-cake"></i>
					<div class="classes-meta-item-content">
						<?php echo esc_html__('Years old','prechool'); ?>
						<span><?php echo $year_olds; ?></span>
					</div>
				</div>
				<div class="classes-meta-item">
					<i class="fa fa-home"></i>
					<div class="classes-meta-item-content">
						<?php echo esc_html__('Class size','prechool'); ?>
						<span><?php echo $class_size; ?></span>
					</div>
				</div>
				<div class="classes-meta-item">
					<i class="fa fa-clock-o"></i>
					<div class="classes-meta-item-content">
						<?php echo esc_html__('Class durantion','prechool'); ?>
						<span><?php echo $class_duration; ?></span>
					</div>
				</div>
				<div class="classes-meta-item">
					<i class="fa fa-car"></i>
					<div class="classes-meta-item-content">
						<?php echo esc_html__('Transportation','prechool'); ?>
						<span><?php echo $transportation; ?></span>
					</div>
				</div>
				<div class="classes-meta-item">
					<i class="fa fa-users"></i>
					<div class="classes-meta-item-content">
						<?php echo esc_html__('Class staff','prechool'); ?>
						<span><?php echo $class_staff; ?></span>
					</div>
				</div>
				
				</div>
				<?php if($jws_theme_classes_show_button_price)?> <a class="btn-pre-v2 button-price" href="<?php echo esc_url($jws_theme_classes_url_price);?>"><?php echo esc_html__($class_price_per_day,'prechool'); ?></a>
				<?php if($jws_theme_classes_show_button_register)?> <a class="btn-pre-v2 button-register" href="<?php echo esc_url($jws_theme_classes_url_register);?>"><?php echo esc_html__('Register today','prechool'); ?></a>
			</div>
			<div class="col-md-6 col-sm-12 col-sx-12">
			<?php if (has_post_thumbnail()) { ?>
				<div id="tb-classes-image" class="flexslider" >
					<ul class="slides">
					<!-- Get Thumb -->
					<?php
						$image_full = '';
						$attachment_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full', false);
						$image_full = $attachment_image[0];
						echo "<li class='ro-image'>";
						if($jws_theme_classes_crop_image){
							$image_resize = matthewruddy_image_resize( $attachment_image[0], $jws_theme_classes_image_width, $jws_theme_classes_image_height, true, false );
							echo '<img style="width:100%;" class="bt-image-cropped" src="'. esc_attr($image_resize['url']) .'" alt="">';
						}else{
							the_post_thumbnail();
						}
						echo '</li>';
					?>
					<?php
					$img_ids = esc_attr( get_post_meta(get_the_ID(), 'jws_theme_post_preview_image', true) );
					$img_ids = explode(",", $img_ids);
					?>
					<?php foreach($img_ids as $id) {
						$attachment_image = wp_get_attachment_image_src($id, 'full', false);
						
						if($id){
						
					?>
						<li class="ro-image">
							<a href="#">
								<?php if($jws_theme_classes_crop_image){
									$image_resize = matthewruddy_image_resize( $attachment_image[0], $jws_theme_classes_image_width, $jws_theme_classes_image_height, true, false );
									echo '<img style="width:100%;" class="bt-image-cropped" src="'. esc_attr($image_resize['url']) .'" alt="">';
								}else{
									echo '<img src="'. $attachment_image[0] .'" alt="">';
								} ?>
							</a>
						</li>
					<?php }
					} ?>
					</ul>
				</div>
				<?php } ?>
			
				<div id="tb-classes-image-carousel" class="flexslider" >
					<ul class="slides">
						<!-- Get Thumb -->
						<?php
							$image_full = '';
							$attachment_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full', false);
							$image_full = $attachment_image[0];
							echo "<li class='ro-image'>";
							if($jws_theme_classes_crop_image){
								$image_resize = matthewruddy_image_resize( $attachment_image[0], $jws_theme_classes_image_width, $jws_theme_classes_image_height, true, false );
								echo '<img style="width:100%;" class="bt-image-cropped" src="'. esc_attr($image_resize['url']) .'" alt="">';
							}else{
								the_post_thumbnail();
							}
							echo '</li>';
						?>
						<?php
						$img_ids = esc_attr( get_post_meta(get_the_ID(), 'jws_theme_post_preview_image', true) );
						$img_ids = explode(",", $img_ids);
						?>
						<?php foreach($img_ids as $id) {
							$attachment_image = wp_get_attachment_image_src($id, 'full', false);
							if($id){
						?>
							<li class="ro-image">
								<a href="#">
									<?php if($jws_theme_classes_crop_image){
										$image_resize = matthewruddy_image_resize( $attachment_image[0], $jws_theme_classes_image_width, $jws_theme_classes_image_height, true, false );
										echo '<img style="width:100%;" class="bt-image-cropped" src="'. esc_attr($image_resize['url']) .'" alt="">';
									}else{
										echo '<img src="'. $attachment_image[0] .'" alt="">';
									} ?>
								</a>
							</li>
						<?php }
						} ?>
					</ul>
				</div>
	        </div>
		</div>
	</div>
	
</article>