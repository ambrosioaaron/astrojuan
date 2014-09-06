

<div class="jumbotron">
    <h2>
    	<?php
		
			echo $article['ArticleTitle'];
		
		?>
    </h2>
    <p class="astro-article-details" style="font-size: 14px;">
    	By: <i><?php echo $article['DisplayName']; ?></i> &nbsp;
        on: <i><?php echo $article['CreateDate']; ?></i>
    </p>
    <div>
    	<?php
		
			echo $article['ArticleContent'];
		
		?>
    </div>
</div>