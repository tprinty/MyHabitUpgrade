

<form id="mhu_technique" class="validate mhu_technique" method="post" action="<?php $this->mhu_admin_link("mhu_process_add_techniques", 'noheader=true'); ?>">

<table class="form-table">
    <tr class="form-field form-required">
      <th scope="row">
      		Technique Type (required)
      </th>
      <td>
      	<input type="text" size="50" name="technique_type" id="technique_type" maxlength="50" value="" aria-required="true" />
      </td>
    </tr>
    
    <tr class="form-field form-required">
      <th scope="row">
      		Technique Level (required)
      </th>
      <td>
        <input type="text" size="50" name="technique_level" id="technique_level" maxlength="75" value="" aria-required="true" />
      </td>
    </tr>
    
    <tr class="form-field form-required">
      <th scope="row">
      		Technique (required)
      </th>
      <td>
        <input type="text" size="50" name="technique" id="technique" maxlength="75" value="" aria-required="true" />
      </td>
    </tr>
 </table>
 
  <h2>How</h2>
  <textarea name="how" rows="7" cols="60"></textarea>

  <h2>Why</h2>
  <textarea name="why" rows="7" cols="60"></textarea>
    

<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="Save" /></p>
</form>
