<div class="jumbotron">
    <?php
			$m = 1;
            $n = 0;
			foreach($articles as $article)
			{
			if( $n == 0)
			{
			?>
            	<div class="astro-article-row row">
            <?php	
			}
			?>
            
                <div class="astro-article col-md-4">
                	<h2><?php echo $article['ArticleTitle']; ?></h2>
                    <p>
                        <?php echo $article['ArticleShortDesc']; ?>
                    </p>
                    <p>By: <?php echo $article['DisplayName']; ?></p>
                    <p><a class="btn btn-default" href="/articles/read/?articleid=<?php echo $article['ArticleId'];;?>">Read article &raquo;</a></p>
                    
            	</div>
            <?php
			if( $n == 2 || $m == count($articles))
			{
			?>
            	</div>
                <hr class="astro-hr"/>
            <?php
			$n = 0;
			}else{
				$n++;
			}
			
			$m++;
			}
			?>
</div>

