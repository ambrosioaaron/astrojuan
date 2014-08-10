<div class="jumbotron">
        	<?php
			$m = 1;
            $n = 0;
			foreach($tips as $tip)
			{
			if( $n == 0)
			{
			?>
            	<div class="astro-tip-row row">
            <?php	
			}
			?>
            
                <div class="astro-tip col-md-4">
                    <h4>By: <?php echo $tip['DisplayName']; ?></h4>
                    <p>
                        <?php echo $tip['TipContent']; ?>
                    </p>
                    <p>
                    <?php
                    for($i=1; $i<=5; $i++)
                    {
                    ?>
                    
                        <span class="glyphicon glyphicon-star <?php if($i<=3){ echo "star-green"; }else{ echo "star-grey"; }?>"></span>
                        
                    <?php
                    }
                    
                    ?>
                    | View Comments
                    </p>
            </div>
            <?php
			if( $n == 2 || $m == count($tips))
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