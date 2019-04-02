<?php
/**
 * @author        JwsTheme
 * @package       LearningOnline/Templates
 * @version       1.0
 */

defined( 'ABSPATH' ) || exit();
global $wp_query;

learning_online_get_template( 'order/order-details.php', array( 'order' => $order ) );
?>
<a href="<?php echo learning_online_get_page_link( 'profile' ); ?>"><?php _e( 'My Profile', 'learningonline' ); ?></a>
