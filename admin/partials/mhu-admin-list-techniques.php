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
                <th>Technique Type</th>
                <th>Technique Level</th>
                <th>Technique</th>
                <th>Active</th>
                <th></th>
            </tr>
        </thead>
<?php foreach ($techniques as $technique){ ?>
	 <tr>
	 	<td><?php print $technique->technique_type; ?></td>
	 	<td><?php print $technique->technique_level; ?></td>
	 	<td><?php print $technique->technique; ?></td>
	 	<td>
	 		<?php if ($technique->active == 1){ ?>
	 			<a href="<?php $this->mhu_admin_link('mhu_deactive_techniques', "id={$technique->id}"); ?>">De-Activate</a>
	 		<?php }else{ ?>
	 			<a href="<?php $this->mhu_admin_link('mhu_active_techniques', "id={$technique->id}"); ?>">Activate</a>
	 		<?php } ?>		
	 	</td>
	 	<td><a href="<?php $this->mhu_admin_link('mhu_edit_techniques', "id={$technique->id}"); ?>">Edit</a></td>
	 </tr>	
	
<?php } ?>
</table>	
