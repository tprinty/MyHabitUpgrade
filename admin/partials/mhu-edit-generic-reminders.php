<?php 

<table class="form-table">
    <tr class="form-field form-required">
      <th scope="row">
      		Message (required)
      </th>
      <td>
        <input type="text" size="150" name="message" id="message" maxlength="150" value="<?php echo $reminder->reminder_text; ?>" aria-required="true" />
      </td>
    </tr>
</table> 
    
<input type="hidden" name="id" value="<?php echo $reminder->id; ?>" />
<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="Save" /></p>
</form>
