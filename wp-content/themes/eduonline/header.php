<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<?php global $jws_theme_options; ?>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" href="<?php echo esc_url( $jws_theme_options['jws_theme_favicon_image']['url'] ); ?>" />
		<?php wp_head(); ?>
	</head>
	<body <?php body_class() ?>>	
		<div id="jws_theme_wrapper">
			<?php
				global $product;
				$jws_theme_display_top_sidebar = jws_theme_get_object_id('jws_theme_display_top_sidebar');
				if(is_active_sidebar( 'tbtheme-top-sidebar' ) && $jws_theme_display_top_sidebar){
				?>
				<div class="jws_theme_top_sidebar_wrap">
					<?php dynamic_sidebar("Top Sidebar"); ?>
				</div>
				<?php
				}
			?>
			<?php jws_theme_header(); ?>
		<?php jws_theme_page_title();?>		