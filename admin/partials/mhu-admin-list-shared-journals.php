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



<table id="shared-journals" class="table table-striped table-bordered dataTable no-footer" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
<thead>
            <tr>
                <th>Date</th>
                <th>User</th>
                <th>Email</th>
            </tr>
        </thead>
<?php foreach ($shares as $share){ ?>
	 <tr>
	 	<td><a href="<?php $this->mhu_admin_link('mhu_view_shared_journal', "id={$share->id}"); ?>"><?php print $share->entry_date; ?></a></td>
	 	<td><?php print $share->display_name; ?></td>
	 	<td><?php print $share->user_email; ?></td>
	 </tr>	
	
<?php } ?>
</table>	
