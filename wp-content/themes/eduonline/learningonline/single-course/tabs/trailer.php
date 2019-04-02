<?php
/**
 * Displaying the description of single course
 *
 * @author  JWSThemes
 * @package LearningOnline/Templates
 * @version 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$course = LP()->global['course'];

if ( !$course ) {
	return;
}
?>

<div class="tb-trainner">
	<?php
	$video_height = '475px';
	$video_trailer = esc_attr( get_post_meta(get_the_ID(), '_lp_video_trailer', true) );
	//var_dump($video_trailer);
	if($video_trailer){
		echo do_shortcode('[video_post height="'.$video_height.'"]'.$video_trailer.'[/video_post]');
		
	}
	?>
</div>