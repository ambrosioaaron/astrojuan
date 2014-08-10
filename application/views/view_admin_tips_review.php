<div class="jumbotron">
	<div class="cold-md-12">
    	<table class="table">
            <tr>
                <th class="col-md-6">Tip</th>
                <th class="col-md-2">Tip By</th>
                <th class="col-md-2">Status</th>
                <th class="cold-md-1"></th>
                <th class="cold-md-1"></th>
            </tr>
            
            <?php
            
                foreach($tips as $tip)
                {
            ?>
                <tr>
                    <td class="cold-md-7 astro-tip"><p><?php echo $tip['TipContent']; ?></p></td>
                    <td class="cold-md-1 astro-tip"><?php echo $tip['DisplayName']; ?></td>
                    <td class="cold-md-2" id="astro-tip-status<?php echo $tip['TipId']; ?>"><?php echo $tip['Status']; ?></td>
                    <td class="cold-md-1">
                    <button data-status-th="astro-tip-status<?php echo $tip['TipId']; ?>" data-tip-id="<?php echo $tip['TipId']; ?>" class="btn btn-default btnEnableTip <?php if($tip['Status']=='Active'){echo'disabled';} ?>" href="#"><span class="glyphicon glyphicon-ok"></span></button>
                    </td>
                    <td class="cold-md-1">
                    <button class="btn btn-default" href="#"><span class="glyphicon glyphicon-ban-circle"></span></button>
                    </td>
                </tr>
            <?php
                }
            
            ?>
        </table>
    </div>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		$('.btnEnableTip').click(function()
		{
			var status_th = $(this).data('status-th');
			$(this).attr('disabled', 'disabled');
			$('#' + status_th).text('Updating...');
			$.ajax({
				 type: "GET",
				 url: "<?php echo base_url();?>admin/tip_enable/", 
				 data: { tipid: $(this).data('tip-id') },
				 success: function(data){
					 if(data!='Transaction Failed')
					 {
						 $('#' + status_th).text('Active');
					 }
				}
			});
		});
	});
</script>