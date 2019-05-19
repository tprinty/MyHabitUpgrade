<h2>Current Techniques</h2>


<table border="1" style="background-color:FFFFCC;border-collapse:collapse;border:1px solid FFCC00;color:000000;width:100%" cellpadding="3" cellspacing="3">
	<tr>
		<th>Type</th>
		<th>Level</th>
		<th>Technique</th>
		<th></th>
	</tr>
	<?php foreach ($techniques as $tec){ ?>
	<tr>
		<td> <?php echo $tec->technique_type; ?> </td>
		<td> <?php echo $tec->technique_level; ?> </td>
		<td> <?php echo $tec->technique; ?> </td>
		<td><a href="<?php $this->mhu_admin_link('mhu_delete_user_techniques', "id={$tec->actid}&user_id={$tec->user_id}"); ?>">Delete</a></td>
	</tr>
	<?php } ?>
	
</table>

<h2>Add Technique</h2>
<form id="mhu_add_technique" method="post" action="<?php $this->mhu_admin_link("mhu_add_user_techniques"); ?>">

<form action="<?php $this->mhu_admin_link('mhu_add_user_techniques'); ?>" method="po">
	<select name="tecid">
  		<option value="Select Technique">Select</option>
  		<?php foreach ($alltechniques as $all){ ?>
  			<option value="<?php echo $all->id; ?>"> <?php echo $all->technique; ?> </option>
  		<?php } ?>
  	</select>
  	<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
  	<input type="submit" value="Add">
  	
</form>
