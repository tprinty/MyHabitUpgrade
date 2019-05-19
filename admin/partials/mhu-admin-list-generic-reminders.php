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



<table id="genericreminders" class="table table-striped table-bordered dataTable no-footer" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
<thead>
            <tr>
                <th>Generic Reminder</th> 
                <th></th>
            </tr>
        </thead>
<?php foreach ($reminders as $reminder){ 
		$out = strtr($reminder->reminder_text,Array("<"=>"&lt;","&"=>"&amp;"));
	?>
	 <tr>
	 	<td><?php echo $out; ?></td>
	 	<td><a href="<?php $this->mhu_admin_link('mhu_edit_generic_reminders', "id={$reminder->id}"); ?>">Edit</a>
	 		<a href="<?php $this->mhu_admin_link('mhu_delete_generic_reminders', "id={$reminder->id}"); ?>">Delete</a>
	 	</td>
	 </tr>	
	
<?php } ?>
</table>
