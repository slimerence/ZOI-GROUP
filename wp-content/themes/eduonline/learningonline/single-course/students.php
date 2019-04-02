<?php
/**
 * Template for displaying course students within the loop
 *
 * @author  JWSThemes
 * @package LearningOnline/Templates
 * @version 2.1.4
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$course = LP()->global['course'];

?>

<span class="course-students">
	<i class="pe-7s-users"></i>
	<?php echo $course->get_students_html(); ?>

</span>
