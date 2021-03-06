<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?> - AstroJuan</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>content/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>content/css/Site.css">
    <script src="<?php echo base_url();?>content/js/jquery-1.10.2.js"></script>
    <script src="<?php echo base_url();?>content/js/bootstrap.js"></script>
    <script src="<?php echo base_url();?>content/js/astrojuan.js"></script>
</head>
<body>
    <div class="navbar navbar-inverse navbar-fixed-top">
        
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="/">Home</a></li>
                    <li><a href="/events/">Events</a></li>
                    <li><a href="/articles/">Articles</a></li>
                    <li><a href="/tips/">Tips</a></li>
                    <li><a href="/about/">About</a></li>
                </ul>
				<ul class="nav navbar-nav navbar-right" id="aj-navbar-login">
                	
                </ul>
            </div>
        </div>
    </div>
    <div style="text-align: center; padding: 10px 0px 10px 0px;">
        <img src="<?php echo base_url();?>content/images/logo.png" />
    </div>
    <div class="container body-content">
        <mp:Content />
        <hr />
        <footer>
            <p>&copy; <?php echo date("Y"); ?> - AstroJuan</p>
        </footer>
    </div>
	
    <script type="text/javascript">
        $(document).ready(function () {
			<?php
				if(empty($hideLogin)){
			?>
			
			$.ajax({
				 type: "GET",
				 url: "<?php echo base_url();?>account/login/", 
				 data: {},
				 success: 
				function(data){
					$('#aj-navbar-login').html(data);
				}
			});
			
			<?php
				}
			?>
		});
    </script>
</body>
</html>
