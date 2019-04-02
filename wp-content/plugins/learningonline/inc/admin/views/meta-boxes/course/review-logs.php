<?php
global $post;
$index = $total_reviews;
?>
<h4>
	<?php if ( $total_reviews ) { ?>
		<?php printf( _nx( '%d review', '%d reviews', $total_reviews, 'learningonline' ), $total_reviews ); ?>
	<?php } else { ?>
		<?php _e( 'This course has not got any reviews yet', 'learningonline' ); ?>
	<?php } ?>
</h4>
<?php if ( $total_reviews ) { ?>
	<ul class="learning-online-review-logs clearfix">
		<?php foreach ( $reviews as $review ) { ?>
			<?php $user = LP_User_Factory::get_user( $review->user_id ); ?>
			<li>
				<div class="review-index">#<?php echo $index --; ?></div>
				<div class="review-user">
					<span class="user-avatar"><?php echo $user->get_profile_picture(); ?></span>
				</div>
				<div class="review-content">
					<strong class="user-nicename"><?php echo learning_online_get_profile_display_name( $user ); ?></strong>
					<div class="review-message"><?php echo $review->message; ?></div>
				<span class="lp-label <?php echo $review->status == 'publish' ? 'lp-label-preview' : ( $review->user_type == 'reviewer' ? 'lp-label-final' : 'lp-label-format' ); ?>">
					<?php echo $review->status == 'publish' ? __( 'Publish', 'learningonline' ) : ( $review->user_type == 'reviewer' ? __( 'Rejected', 'learningonline' ) : __( 'Submit for review', 'learningonline' ) ); ?>
				</span>
					&nbsp;&nbsp;
					<span><?php echo mysql2date( get_option( 'date_format' ), $review->date ); ?></span>
					<?php if ( current_user_can( 'delete_others_lp_courses' ) ) { ?>
						&nbsp;&nbsp;
						<a href="<?php echo wp_nonce_url( admin_url( 'post.php?post=' . $post->ID . '&action=edit&delete_log=' . $review->review_log_id ), 'delete_log_' . $post->ID . '_' . $review->review_log_id ); ?>"><?php _e( 'Delete', 'learningonline' ); ?></a>
					<?php } ?>
				</div>
			</li>
		<?php } ?>
	</ul>
	<?php if ( $total_reviews > 10 ) { ?>
		<p>
			<?php if ( $total_reviews == $count_reviews ) { ?>
				<a href="<?php echo remove_query_arg( 'view_all_review' ); ?>"><?php _e( 'View less', 'learningonline' ); ?></a>
			<?php } else { ?>
				<a href="<?php echo add_query_arg( 'view_all_review', '1' ); ?>"><?php _e( 'View all', 'learningonline' ); ?></a>
			<?php } ?>
		</p>
	<?php } ?>
<?php } ?>
