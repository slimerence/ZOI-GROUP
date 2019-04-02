<div class="no-results">
	<h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'eduonline' ); ?></h1>
	<p><?php printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'eduonline' ),array( 'a' => array( 'href' => array() ))), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>
</div>