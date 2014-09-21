<div class="jumbotron">
    <div class="row">
        <div class="col-md-4">
        	<span>
            Express something in 420 characters!
            </span><br /><br />
            <span class="astro-tip-label">Post your tip</span>
            <br /><br />
            <?php
                    
				echo form_open('/account/tips', $form_attribute);
	
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
				
				echo form_input($tip_id);
				
				echo form_textarea($tip_content);
				
				echo '<br/>';
				
				echo $captcha;
				
				echo '<br/><br/>';
				
				echo form_input($captchaAttr);
				
				echo '<br/>';
				
				?>
                
                <div class="row">
                	<div class="astro-tip-submit col-md-6"><?php echo form_submit($btn_submit); ?></div>
                	<div class="col-md-6"><input type="button" class="astro-tip-edit-cancel btn btn-default btn-sm" value="Cancel" /></div>
                </div>
                
                <?php
				echo form_close();
			?>
        </div>
        <div class="col-md-8">
            <table class="table">
            	<tr>
                	<th class="col-md-7">Tip</th>
                    <th class="col-md-3">Status</th>
                    <th class="cold-md-1"></th>
                    <th class="cold-md-1"></th>
                </tr>
                
                <?php
                
                	foreach($tips as $tip)
					{
				?>
                	<tr>
                    	<td class="cold-md-7 astro-tip"><p><?php echo $tip['TipContent']; ?></p></td>
                        <td class="cold-md-3" id="astro-tip-status<?php echo $tip['TipId']; ?>"><?php echo $tip['Status']; ?></td>
                        <td class="cold-md-1">
                        <button class="btn btn-default astro-tip-edit" href="#" data-tip-id="<?php echo $tip['TipId']; ?>"><span class="glyphicon glyphicon-pencil"></span></button>
                        </td>
                        <td class="cold-md-1">
                        <button class="btn btn-default astro-tip-disable" href="#"  data-status-th="astro-tip-status<?php echo $tip['TipId']; ?>" data-owner="<?php echo $tip['CreatedBy']; ?>" data-tip-id="<?php echo $tip['TipId']; ?>"><span class="glyphicon glyphicon-ban-circle"></span></button>
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
		$('.astro-tip-edit').click(function(){
			$('.astro-tip-edit-cancel').show();
			$('.astro-tip-label').text('Update your tip');
			$('.astro-tip-edit').removeAttr('disabled');
			$(this).prop('disabled','disabled');
			$('#tip_id').val($(this).data('tip-id'));
			$('#tip_content').val($(this).parent().parent().find('.astro-tip').children('p').text());
			
		});
		
		$('.astro-tip-edit-cancel').click(function() {
			$('.astro-tip-label').text('Post your tip');
			$('.astro-tip-edit').removeAttr('disabled');
			$('#tip_id').val('');
			$('#tip_content').val('');
			$(this).hide();
		});
		
		
		$('.astro-tip-disable').click(function (){
			$(this).parent().parent().find('.astro-tip-edit').hide();
			$(this).parent().parent().find('.astro-tip-disable').hide();
			
			var status_th = $(this).data('status-th');
			$(this).attr('disabled', 'disabled');
			$('#' + status_th).text('Updating...');
			$.ajax({
				 type: "GET",
				 url: "<?php echo base_url();?>account/tip_disable/", 
				 data: { tip_id: $(this).data('tip-id'), tip_owner_id: $(this).data('owner') },
				 success: function(data){
					 if(data!='Transaction Failed')
					 {
						 $('#' + status_th).text('Deleted');
					 }
				}
			});
		});
	});
</script>