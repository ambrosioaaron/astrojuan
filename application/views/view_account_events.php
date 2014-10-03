<div class="jumbotron">
    <div class="row">
        <div class="col-md-4">
            <span class="astro-event-label">Announce your Event!</span>
            <br /><br />
            <?php
                    
				echo form_open('/account/events', $form_attribute);
	
				if (isset($validation_errors))
				{
					foreach ($validation_errors as $key=>$value) {
						if($value != '')
						{
							?>
							
                            <div class="bs-callout bs-callout-danger" id="divFormError">
                                <?php echo str_replace(array('<p>','</p>'),'',$value); ?>
                            </div>
							
							<?php
						}
					}
				}
				
				echo form_input($event_id);
				
				echo form_input($event_title);
				
				echo '<br/>';
				
				echo form_textarea($event_banner);
				
				echo '<br/>';
				
				echo $captcha;
				
				echo '<br/><br/>';
				
				echo form_input($captchaAttr);
				
				echo '<br/>';
				
				?>
                
                <div class="row">
                	<div class="astro-event-submit col-md-6"><?php echo form_submit($btn_submit); ?></div>
                	<div class="col-md-6"><input type="button" class="astro-event-edit-cancel btn btn-default btn-sm" value="Cancel" /></div>
                </div>
                
                <?php
				echo form_close();
			?>
        </div>
        <div class="col-md-8">
            <table class="table">
            	<tr>
                	<th class="col-md-2">Events</th>
                    <th class="col-md-5">Banner</th>
                    <th class="cold-md-3">Status</th>
                    <th class="cold-md-1"></th>
                    <th class="cold-md-1"></th>
                </tr>
                
                <?php
                
                	foreach($events as $event)
					{
				?>
                	<tr>
                    	<td class="cold-md-2 astro-event"><p><?php echo $event['EventTitle']; ?></p></td>
                        <td class="cold-md-5"><img src="<?php echo $event['EventBannerURL']; ?>" width:100%;/></td>
                        <td class="cold-md-3" id="astro-event-status<?php echo $event['EventId']; ?>"><?php echo $event['Status']; ?></td>
                        <td class="cold-md-1">
                        <button class="btn btn-default astro-event-edit" href="#" data-event-banner="<?php echo $event['EventBannerURL']; ?>" data-event-id="<?php echo $event['EventId']; ?>"><span class="glyphicon glyphicon-pencil"></span></button>
                        </td>
                        <td class="cold-md-1">
                        <button class="btn btn-default astro-event-disable" href="#"  data-status-td="astro-event-status<?php echo $event['EventId']; ?>" data-owner="<?php echo $event['CreatedBy']; ?>" data-event-id="<?php echo $event['EventId']; ?>"><span class="glyphicon glyphicon-ban-circle"></span></button>
                        </td>
                    </tr>
                <?php
					}
                
                ?>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('.astro-event-edit').click(function(){
			$('.astro-event-edit-cancel').show();
			$('.astro-event-label').text('Update your Event');
			$('.astro-event-edit').removeAttr('disabled');
			$(this).prop('disabled','disabled');
			$('#event_id').val($(this).data('event-id'));
			$('#event_banner').val($(this).data('event-banner'));
			$('#event_title').val($(this).parent().parent().find('.astro-event').children('p').text());
			
		});
		
		$('.astro-event-edit-cancel').click(function() {
			$('.astro-event-label').text('Announce your Event');
			$('.astro-event-edit').removeAttr('disabled');
			$('#event_id').val('');
			$('#event_title').val('');
			$('#event_banner').val('');
			$(this).hide();
		});
		
		
		$('.astro-event-disable').click(function (){
			$(this).parent().parent().find('.astro-event-edit').hide();
			$(this).parent().parent().find('.astro-event-disable').hide();
			
			var status_td = $(this).data('status-td');
			$(this).attr('disabled', 'disabled');
			$('#' + status_td).text('Updating...');
			$.ajax({
				 type: "GET",
				 url: "<?php echo base_url();?>account/event_disable/", 
				 data: { event_id: $(this).data('event-id'), event_owner_id: $(this).data('owner') },
				 success: function(data){
					 if(data!='Transaction Failed')
					 {
						 $('#' + status_td).text('Deleted');
					 }
				}
			});
		});
	});
</script>