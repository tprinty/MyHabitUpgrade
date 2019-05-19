<?php
/**
 * Provide a dashboard view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<?php  

	$stuff = $journal[0];
?>


<h4><?php echo htmlspecialchars(stripslashes($stuff->question_1_text)); ?> </h4>
<p><?php echo htmlspecialchars(stripslashes($stuff->question_1_answer)); ?></p>
<br />
<h4><?php echo htmlspecialchars(stripslashes($stuff->question_2_text)); ?> </h4>
<p><?php echo htmlspecialchars(stripslashes($stuff->question_2_answer)); ?></p>




