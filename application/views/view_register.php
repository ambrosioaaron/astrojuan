<div class="jumbotron">
    <!--<form role="form" class="form-horizontal" id="frmRegister" name="Register" method="post" action="/account/register/">
		<div class="form-group">
            
            <input type="text" class="form-control" id="display_name" name="display_name" placeholder="Display Name" data-toggle="popover" data-trigger="focus" data-placement="right" data-content="Letters and numbers only" />
        
            <input type="text" class="form-control" id="email_address" name="email_address" placeholder="Email Address"  data-toggle="popover" data-trigger="focus" data-placement="right" data-content="Enter a your email address" />
            
            <input type="password" class="form-control" id="user_password" name="user_password" placeholder="Password" data-toggle="popover" data-trigger="focus" data-placement="right" data-content="6 to 20 characters only" />
            
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm password"  data-toggle="popover" data-trigger="focus" data-placement="right" data-content="Re-type your password" />
            
            <input type="submit" value="Register" class="form-control btn btn-success btn-sm"/>
        
		</div>
        
	</form>-->
    
    <?php
                    
		echo form_open('/account/register', $formAttr);
	?>
	<div class="form-group">
	<?php
		echo form_input($displayNameAttr);
		echo form_input($emailAddressAttr);
		echo form_password($userPassswordAttr);
		echo form_password($confirmPasswordAttr);
	
	?>
	<input type="submit" value="Register" class="form-control btn btn-success btn-sm"/>
	</div>
	<?php
		echo form_close();
	?>
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
	
	<?php
	
		if (isset($validation_errors))
		{
			while ($error = current($validation_errors)) {
			?>
			
			$('#<?php echo key($validation_errors); ?>').attr('data-content', '<?php str_replace(array('<p>','</p>'),'',$error); ?>');
			$('#<?php echo key($validation_errors); ?>').focus();
			
			<?php
				next($validation_errors);
			}
        }
	
	?>
});
</script>