<?php if(isset($validLogin) && $validLogin){ ?>

	<li class="ir-navbar-li" id="ir-navbar-username"><a href="#">Welcome, </a></li>
    <li class="ir-navbar-li dropdown" id="ir-navbar-logout">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">My Account<span class="caret"></span></a>
        <ul class="dropdown-menu">
            <li><a href="/Account/AccountProfile">Profile</a></li>
            <li><a href="/Account/ChangePassword">Change Password</a></li>
        </ul>
    </li>

    <li class="ir-navbar-li" id="ir-navbar-logout"><a href="/Account/Logout">Logout</a></li>
    
<?php }else{ ?>

    <li class="aj-navbar-li" id="aj-navbar-register">
        <a href="/Account/Register">Register</a>
    </li>
    
    <li class="aj-navbar-li dropdown <?php if (isset($validLogin) && !$validLogin){ echo "open"; }?>">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Login<span class="caret"></span></a>
        <?php
                    
            echo form_open('/account/login', $formAttr);
        ?>
        <div class="form-group">
        <?php
            if (isset($validLogin) && !$validLogin)
            {
        ?>
        <div class="bs-callout bs-callout-danger" id="divLoginError">
            <h4>Invalid Login</h4> 
        </div>
        <?php	
            }
    
            echo form_input($emailAttr);
                
            echo form_password($passwordAttr);
        
        ?>
        <button id="btnLogin" type="submit" class="form-control btn btn-success btn-sm" name="login_submit">
            <span class="spinner"><i class="icon-spin icon-refresh"></i></span>
            Login
        </button>
        </div>
        <?php
            echo form_close();
        ?>
    </li>

<?php } ?>

<script type="text/javascript">
	$(document).ready(function () {
		
		$('#frmLogin').submit(function (){

			astroBlock("#frmLogin", "Logging in...");

            $.ajax({
                url: '<?php echo base_url();?>account/login/',
                type: 'POST',
                data: $(this).serialize(),
                success: function (data) {
					
                    $('#aj-navbar-login').html(data);
                    astroUnBlock("#frmLogin");
                }
            });

			return false;
		});
		
	});
</script>
