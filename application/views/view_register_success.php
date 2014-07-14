<div class="jumbotron">
    <div class="row">
    <div class="col-md-12">
        <h2>Registration Success</h2>
        <p>
            Welcome to AstroJuan! Click <a href="#" id="lnkLogin">here</a> to login.
        </p>
    </div>
</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('#lnkLogin').click(function(e){
    	e.stopPropagation();
    	$("#aj-li-Login").dropdown('toggle');
		$("#email").focus();
	});
});
</script>