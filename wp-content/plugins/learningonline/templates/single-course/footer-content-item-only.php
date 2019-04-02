<?php
/**
 * @author JwsTheme
 * @version 2.0.6
 */
ob_start();
get_footer();
$footer = ob_get_clean();

// Find signal we added before
preg_match( '/(<!-- LEARNING-ONLINE-REMOVE-UNWANTED-PARTS -->)/', $footer, $matches );

// Split by our signal
$footer_parts = preg_split( '/(<!-- LEARNING-ONLINE-REMOVE-UNWANTED-PARTS -->)/', $footer );

// Output our footer with unwanted sections has removed
echo $footer_parts[1];

// No output anything after closing tag </html>
ob_start();