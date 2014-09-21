<div class="jumbotron">
	<div class="cold-md-12">
    	<table class="table">
            <tr>
                <th class="col-md-6">Article</th>
                <th class="col-md-2">Author</th>
                <th class="col-md-2">Status</th>
                <th class="cold-md-1"></th>
                <th class="cold-md-1"></th>
            </tr>
            
            <?php
            
                foreach($articles as $article)
                {
            ?>
                <tr>
                    <td class="cold-md-7 astro-article"><p><?php echo $article['ArticleTitle']; ?></p></td>
                    <td class="cold-md-1 astro-article"><?php echo $article['DisplayName']; ?></td>
                    <td class="cold-md-2" id="astro-article-status<?php echo $article['ArticleId']; ?>"><?php echo $article['Status']; ?></td>
                    <td class="cold-md-1">
                    <button data-status-th="astro-article-status<?php echo $article['ArticleId']; ?>" data-article-id="<?php echo $article['ArticleId']; ?>" class="btn btn-default astro-article-enable <?php if($article['Status']=='Active'){echo'disabled';} ?>" href="#"><span class="glyphicon glyphicon-ok"></span></button>
                    </td>
                    <td class="cold-md-1">
                    <button class="btn btn-default astro-article-disable <?php if($article['Status']=='Disabled'){echo'disabled';} ?>" href="#"  data-status-td="astro-article-status<?php echo $article['ArticleId']; ?>" data-article-owner="<?php echo $article['CreatedBy']; ?>" data-article-id="<?php echo $article['ArticleId']; ?>"><span class="glyphicon glyphicon-ban-circle"></span></button>
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
		$('.astro-article-enable').click(function()
		{
			var status_th = $(this).data('status-th');
			$(this).removeClass('disabled');
			$('.astro-article-disable').removeClass('disabled');
			$('#' + status_th).text('Updating...');
			$.ajax({
				 type: "GET",
				 url: "<?php echo base_url();?>admin/article_enable/", 
				 data: { articleid: $(this).data('article-id') },
				 success: function(data){
					 if(data!='Transaction Failed')
					 {
						 $('#' + status_th).text('Active');
					 }
				}
			});
		});
		
		$('.astro-article-disable').click(function(){
			
			var status_td = $(this).data('status-td');
			$(this).addClass('disabled');
			$('.astro-article-enable').removeClass('disabled');
			$('#' + status_td).text('Updating...');
			$.ajax({
				 type: "GET",
				 url: "<?php echo base_url();?>admin/article_disable/", 
				 data: { article_id: $(this).data('article-id') },
				 success: function(data){
					 if(data!='Transaction Failed')
					 {
						 $('#' + status_td).text('Disabled');
					 }
				}
			});
		});
	});
</script>