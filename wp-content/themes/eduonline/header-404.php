<!DOCTYPE html>
<?php $jws_theme_options = $GLOBALS['jws_theme_options']; ?>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ):?>
		<link rel="shortcut icon" href="<?php echo esc_url( $jws_theme_options['jws_theme_favicon_image']['url'] ); ?>" />
		<?php endif; ?>
		<?php wp_head(); ?>
	</head>
	<body <?php body_class() ?>>
		<?php
			$post_id = isset( $jws_theme_options['jws_theme_error404_page_id'] ) ? intval( $jws_theme_options['jws_theme_error404_page_id'] ) : 0;
		?>
		<div id="jws_theme_wrapper">
			<?php
				$jws_theme_display_top_sidebar = get_post_meta( $post_id, 'jws_theme_display_top_sidebar', true ) ? get_post_meta( $post_id, 'jws_theme_display_top_sidebar', true ) : ( isset( $jws_theme_options['jws_theme_error404_display_top_sidebar'] ) ? intval( $jws_theme_options['jws_theme_error404_display_top_sidebar'] ) : 0 );
				$jws_theme_display_header = isset( $jws_theme_options['jws_theme_error404_display_header'] ) ? intval( $jws_theme_options['jws_theme_error404_display_header'] ) : 0;
				$jws_theme_display_title = isset( $jws_theme_options['jws_theme_error404_display_title'] ) ? intval( $jws_theme_options['jws_theme_error404_display_title'] ) : 0;
				if( $jws_theme_display_top_sidebar && is_active_sidebar( 'tbtheme-top-sidebar' )){
				?>
				<div class="jws_theme_top_sidebar_wrap">
					<?php dynamic_sidebar("Top Sidebar"); ?>
				</div>
				<?php
				}
			?>
			<?php if( $jws_theme_display_header ) jws_theme_header(); ?>
		<?php if( $jws_theme_display_title ) jws_theme_page_title();?>		