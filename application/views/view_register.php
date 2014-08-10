<div class="jumbotron">
    <div class="row">
        <div class="col-md-6">
            <h2>Create your account</h2>
            <p>
                Welcome to AstroJuan! By creating an account, you can:
                <ul>
                	<li>place text here</li>
                    <li>place text here</li>
                    <li>place text here</li>
                    <li>place text here</li>
                    <li>place text here</li>
                    <li>place text here</li>
                </ul>
            </p>
        </div>
        
        <div class="col-md-6">
            <p>
                <?php
                    echo form_open('/account/register', $formAttr);
                ?>
                <div class="form-group">
                <?php
                    echo form_input($displayNameAttr);
                    echo form_input($emailAddressAttr);
                    echo form_password($userPassswordAttr);
                    echo form_password($confirmPasswordAttr);
                    echo $captcha;
                    echo form_input($captchaAttr);
                ?>
                <input type="submit" value="Create account" class="form-control btn btn-success btn-sm"/>
                </div>
                <?php
                    echo form_close();
                ?>
            </p>
        </div>

	</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	$('#frmRegister').submit(function(){
		var displayName = validateDisplayName($('#display_name').val());
		if(displayName != true)
		{
			$('#display_name').attr('data-content', displayName);
			$('#display_name').focus();
			
			return false;
		}
		
		var email_address = validateEmail($('#email_address').val());
		if(email_address != true)
		{
			$('#email_address').attr('data-content', email_address);
			$('#email_address').focus();
			
			return false;
		}
		
		var user_password = validatePassword($('#user_password').val());
		if(user_password != true)
		{
			$('#user_password').attr('data-content', user_password);
			$('#user_password').focus();
			
			return false;
		}
		
		var confirm_password = confirmPassword($('#user_password').val(), $('#confirm_password').val());
		if(confirm_password != true)
		{
			$('#confirm_password').attr('data-content', confirm_password);
			$('#confirm_password').focus();
			
			return false;
		}
	});
	$('#display_name').popover();
	$('#email_address').popover();
	$('#user_password').popover();
	$('#confirm_password').popover();
	$('#captcha_input').popover();
	
	<?php
	
		if (isset($validation_errors))
		{
			foreach ($validation_errors as $key=>$value) {
				if($value != '')
				{
					?>
					
					$('#<?php echo $key; ?>').attr('data-content', '<?php echo str_replace(array('<p>','</p>'),'',$value); ?>');
					$('#<?php echo $key; ?>').focus();
					
					<?php
				}
			}
        }
	
	?>
});
</script>