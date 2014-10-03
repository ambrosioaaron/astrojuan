<div class="jumbotron">
	<div class="cold-md-12">
    	<table class="table">
            <tr>
                <th class="col-md-6">Event</th>
                <th class="col-md-2">Event By</th>
                <th class="col-md-2">Status</th>
                <th class="cold-md-1"></th>
                <th class="cold-md-1"></th>
            </tr>
            
            <?php
            
                foreach($events as $event)
                {
            ?>
                <tr>
                    <td class="cold-md-7 astro-event"><p><?php echo $event['EventTitle']; ?></p></td>
                    <td class="cold-md-1 astro-event"><?php echo $event['DisplayName']; ?></td>
                    <td class="cold-md-2" id="astro-event-status<?php echo $event['EventId']; ?>"><?php echo $event['Status']; ?></td>
                    <td class="cold-md-1">
                    <button data-status-td="astro-event-status<?php echo $event['EventId']; ?>" data-event-id="<?php echo $event['EventId']; ?>" class="astro-event-enable btn btn-default <?php if($event['Status']=='Active'){echo'disabled';} ?>" href="#"><span class="glyphicon glyphicon-ok"></span></button>
                    </td>
                    <td class="cold-md-1">
                    <button class="btn btn-default astro-event-disable <?php if($event['Status']=='Disabled'){echo'disabled';} ?>" href="#" data-status-td="astro-event-status<?php echo $event['EventId']; ?>" data-owner="<?php echo $event['CreatedBy']; ?>" data-event-id="<?php echo $event['EventId']; ?>"><span class="glyphicon glyphicon-ban-circle"></span></button>
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
		$('.astro-event-enable').click(function()
		{
			var status_td = $(this).data('status-td');
			var me = $(this);
			
			me.addClass('disabled');
			$('#' + status_td).text('Updating...');
			$.ajax({
				 type: "GET",
				 url: "<?php echo base_url();?>admin/event_enable/", 
				 data: { eventid: $(this).data('event-id') },
				 success: function(data){
					 if(data!='Transaction Failed')
					 {
						 me.parent().parent().find('.astro-event-disable').removeClass('disabled');
						 $('#' + status_td).text('Active');
					 }
				}
			});
		});
		
		$('.astro-event-disable').click(function (){
			var status_td = $(this).data('status-td');
			var me = $(this);
			
			me.addClass('disabled');
			$('#' + status_td).text('Updating...');
			$.ajax({
				 type: "GET",
				 url: "<?php echo base_url();?>admin/event_disable/", 
				 data: { event_id: $(this).data('event-id'), event_owner_id: $(this).data('owner') },
				 success: function(data){
					 if(data!='Transaction Failed')
					 {
						 me.parent().parent().find('.astro-event-enable').removeClass('disabled');
						 $('#' + status_td).text('Disabled');
					 }
				}
			});
		});
	});
</script>