<div class="jumbotron">
    <form role="form" class="form-horizontal" id="frmRegister" name="Register" method="post" action="/account/register/">
		<div class="form-group">
			<label class="col-sm-2 control-label"  for="username">Username</label>
            <div class="input-group">
              	<span class="input-group-addon">*</span>
                <input type="text" class="form-control" id="username" name="username" placeholder="Username" required="required">
			</div>
            <label class="error label label-danger" for="username"></label>           
		</div>
        <input type="submit" value="Register"/>
	</form>
</div>

<script type='text/javascript'>
$(function() {
 $('#username').focus();
 
 $('#frmRegister').validate({
  highlight: function(element) {
   $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
   $(element).closest('.form-group').children('.error').removeClass('hide');
  },
  success: function(element) {
   $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
   $(element).addClass('hide');
  }
 });  
});
</script>