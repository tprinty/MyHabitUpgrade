<?php 

/**
 * Provide a dashboard view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://www.edisonave.com
 *
 * @package    mhu
 * @subpackage mhu/admin/partials
 */


?>


<table id="techniques" class="table table-striped table-bordered dataTable no-footer" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
<thead>
            <tr>
                <th>Name</th>
                <th>Reg Date</th>
                <th>E-Mail</th>
                <th>Cell</th>
                <th>Notification Type</th>
                <th></th>
            </tr>
        </thead>
<?php foreach ($mhu_users as $mhu_user){ ?>
	 <tr>
	 	<td><?php print $mhu_user->first_name ." ". $mhu_user->last_name; ?></td>
	 	<td><?php print $mhu_user->user_registered; ?></td>
	 	<td><?php print $mhu_user->user_email; ?></td>
	 	<td><?php print $mhu_user->cell_number; ?></td>
	 	<td><?php print implode(", ", json_decode($mhu_user->answer_14)); ?></td>
	 	<td><a href="<?php $this->mhu_admin_link('mhu_edit_user_techniques', "id={$mhu_user->wp_user_id}"); ?>">Edit Techniques</a></td>
	 </tr>	
	
<?php } ?>
</table>	





