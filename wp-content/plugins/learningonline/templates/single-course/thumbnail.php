<?php
/**
 * Template for displaying the thumbnail of a course
 *
 * @author  JwsTheme
 * @package LearningOnline/Templates
 * @version 2.0.6
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $post;
$course      = learning_online_get_course();
$video_embed = $course->get_video_embed();
if ( $video_embed ):
	?>
	<div class="course-video">
		<?php echo $video_embed; ?>
	</div>
	<?php
endif;
if ( !has_post_thumbnail() || $video_embed ) {
	return;
}
?>
<div class="course-thumbnail">
	<?php
	$image_title   = get_the_title( get_post_thumbnail_id() ) ? esc_attr( get_the_title( get_post_thumbnail_id() ) ) : '';
	$image_caption = get_post( get_post_thumbnail_id() ) ? esc_attr( get_post( get_post_thumbnail_id() )->post_excerpt ) : '""';
	$image_link    = wp_get_attachment_url( get_post_thumbnail_id() );
	$image         = get_the_post_thumbnail( $post->ID, apply_filters( 'single_course_image_size', 'single_course' ), array(
		'title' => $image_title,
		'alt'   => $image_title
	) );

	echo apply_filters(
		'learning_online_single_course_image_html',
		sprintf( '<a href="%s" itemprop="image" class="learning-online-single-thumbnail" title="%s">%s</a>', $image_link, $image_caption, $image ),
		$post->ID
	);
	?>
</div>
