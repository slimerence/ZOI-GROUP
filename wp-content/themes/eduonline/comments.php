<?php
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">
	<ul class="nav nav-tabs">
		<?php if ( have_comments() ) : ?>
		
		<li class="active"><a data-toggle="tab" href="#formcomment"><?php echo __( '<span>Leave Your comments</span>', 'eduonline' );?></a></li>
		<li ><a data-toggle="tab" href="#comments-nav"><?php comments_number( __('Comment','eduonline'), __('Comment <label>(1)</label>','eduonline'), __('Comments <label>(%)</label>','eduonline')); ?></a></li>
		<?php endif; // have_comments() ?>
	  </ul>
	<?php // You can start editing here -- including this comment! ?>
	<div class="tab-content">
	<?php if ( have_comments() ) : ?>
	
		<div id="comments-nav" class="tab-pane fade">
		
			<ol class="comment-list">
				<?php
					wp_list_comments( array(
						'style'      => 'ol',
						'short_ping' => true,
						'avatar_size' => 90,
						'callback' => 'jws_theme_custom_comment',
						'reply_text' => '<i class="fa fa-mail-reply"></i>',
					) );
				?>
			</ol><!-- .comment-list -->

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
			<nav id="comment-nav-below" class="comment-navigation" role="navigation">
				<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'eduonline' ); ?></h1>
				<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'eduonline' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'eduonline' ) ); ?></div>
			</nav><!-- #comment-nav-below -->
			<?php endif; // check for comment navigation ?>
		
		</div>
	<?php endif; // have_comments() ?>
	<div id="formcomment" class="tab-pane fade in active">
	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php _e( 'Comments are closed.', 'eduonline' ); ?></p>
	<?php endif; ?>

	<?php
		$commenter = wp_get_current_commenter();
		
		$fields =  array(
			'author' =>
				'<p class="comment-form-author"><label>' . __("Name", 'eduonline') . ' <span>*</span></label><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" /></p>',

			'email' =>
				'<p class="comment-form-email"><label>' . __("Email", 'eduonline') . ' <span>*</span></label><input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-required="true" /></p>',

			'url' => '<p class="comment-form-url"><label>' . __("Website", 'eduonline') . '</label><input id="url" name="url" type="text" value="' . esc_attr(  $commenter['comment_author_url'] ) .
				'" size="30" aria-required="true" /></p>',
		);
		
		$args = array(
			'id_form'           => 'commentform',
			'id_submit'         => 'submit',
			'class_submit'      => 'submit',
			'name_submit'       => 'submit',
			'title_reply'       => __( '<span></span>', 'eduonline' ),
			'title_reply_to'    => __( 'Leave a reply %s', 'eduonline' ),
			'cancel_reply_link' => __( '', 'eduonline' ),
			'label_submit'      => __( 'Send us', 'eduonline' ),
			'format'            => 'xhtml',

			'comment_field' =>  '<p class="comment-form-comment"><label>' . __("Content", 'eduonline') . ' <span>*</span></label><textarea id="comment" name="comment" cols="60" rows="6" aria-required="true">' . '</textarea></p>',

			'must_log_in' => '<p class="must-log-in">' .
			  sprintf(
				__( 'You must be <a href="%s">logged in</a> to post a comment.', 'eduonline' ),
				wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
			  ) . '</p>',

			'logged_in_as' => '<p class="logged-in-as">' .
			  sprintf(
			  __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'eduonline' ),
				admin_url( 'profile.php' ),
				$user_identity,
				wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )
			  ) . '</p>',

			'comment_notes_before' => '',

			'comment_notes_after' => '',

			'fields' => apply_filters( 'comment_form_default_fields', $fields ),
		  );

		comment_form($args);
	?>
	</div>
	</div>

</div><!-- #comments -->
