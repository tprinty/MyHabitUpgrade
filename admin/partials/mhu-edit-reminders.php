<?php 


<form id="mhu_reminder" class="validate mhu_reminder" name="mhu_reminder" method="post" action="<?php $this->mhu_admin_link("mhu_update_reminders", 'noheader=true'); ?>">

<table class="form-table">
    <tr class="form-field form-required">
      <th scope="row">
      		Technique (required)
      </th>
      <td>
      			<select name="technique_id">
      				<?php foreach($techniques as $technique){ ?>
    				<option value="<?php echo $technique->id ?>" <?php if ($technique->id ==$reminder->technique_id){ echo "selected=true";} ?> ><?php echo $technique->technique ?></option>
    				<?php } ?>
  				</select>
      	
      	
      </td>
    </tr>
    
    <tr class="form-field form-required">
      <th scope="row">
      		Message (required)
      </th>
      <td>
        <input type="text" size="150" name="message" id="message" maxlength="150" value="<?php echo $reminder->message; ?>" aria-required="true" />
      </td>
    </tr>
</table> 
    
<input type="hidden" name="id" value="<?php echo $reminder->id; ?>" />
<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="Save" /></p>
</form>
