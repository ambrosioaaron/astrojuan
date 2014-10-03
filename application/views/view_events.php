<div class="jumbotron">
        	<?php
			$m = 1;
            $n = 0;
			foreach($events as $event)
			{
			if( $n == 0)
			{
			?>
            	<div class="astro-event-row row">
            <?php	
			}
			?>
            
                <div class="astro-event col-md-4">
                    <h4>By: <?php echo $event['DisplayName']; ?></h4>
                    <div>
                    	<a href="#" data-toggle="modal" data-target="#modal<?php echo $event['EventId']; ?>"><img src="<?php echo $event['EventBannerURL']; ?>" width="100%"/></a>
                        
                        <div class="modal fade" id="modal<?php echo $event['EventId']; ?>" tabindex="-1" role="dialog" aria-labelledby="modal<?php echo $event['EventId']; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                  	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" style="text-align:center;"><?php echo $event['EventTitle']; ?></h4>
                                  </div>
                                  <div class="modal-body">
                                    <img src="<?php echo $event['EventBannerURL']; ?>" width="100%"/>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p>
                    View Comments
                    </p>
            </div>
            <?php
			if( $n == 2 || $m == count($events))
			{
			?>
            	</div>
                <hr/>
            <?php
			$n = 0;
			}else{
				$n++;
			}
			
			$m++;
			}
			?>
</div>