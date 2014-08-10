<div class="jumbotron">
    <div class="row">
        <div class="col-md-4">
        	<span>
            Express something in 420 characters!
            </span><br /><br />
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
				
				echo form_textarea($tip_content);
				
				echo '<br/>';
				
				echo form_submit($btn_submit);
				
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
                        <td class="cold-md-3"><?php echo $tip['Status']; ?></td>
                        <td class="cold-md-1">
                        <button class="btn btn-default" href="#"><span class="glyphicon glyphicon-pencil"></span></button>
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
</div>