<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - <?php echo $title; ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>content/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>content/css/Site.css">
    <script src="<?php echo base_url();?>content/js/jquery-1.10.2.js"></script>
    <script src="<?php echo base_url();?>content/js/bootstrap.js"></script>
</head>
<body>
    <div class="navbar navbar-inverse navbar-fixed-top">
        
        <div class="container">
            <a href="/" class="navbar-brand navbar-right">JUANPOT</a>
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="admin/">Home</a></li>
                    <li><a href="admin/events/">Events</a></li>
                    <li><a href="admin/articles/">Articles</a></li>
                    <li><a href="#">Forum</a></li>
                    <li><a href="#">Store</a></li>
                    <li><a href="admin/accounts/">Accounts</a></li>
                </ul>

            </div>
        </div>
    </div>
    <div class="container body-content">
        <mp:Content />
        <hr />
        <footer>
            <p>&copy; <?php echo date("Y"); ?> - JuanPot</p>
        </footer>
    </div>
	
    
</body>
</html>
