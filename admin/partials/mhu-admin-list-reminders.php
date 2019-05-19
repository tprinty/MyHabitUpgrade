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



<table id="techniques" class="table table-striped table-bordered dataTable no-footer" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
<thead>
            <tr>
                <th>Technique</th>
                <th>Reminder</th>
                <th></th>
            </tr>
        </thead>
<?php foreach ($reminders as $reminder){ ?>
	 <tr>
	 	<td><?php print $reminder->technique; ?></td>
	 	<td><?php print $reminder->message; ?></td>
	 	<td><a href="<?php $this->mhu_admin_link('mhu_edit_reminders', "id={$reminder->id}"); ?>">Edit</a></td>
	 </tr>	
	
<?php } ?>
</table>	
