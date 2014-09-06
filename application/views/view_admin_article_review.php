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
                    <button data-status-th="astro-article-status<?php echo $article['ArticleId']; ?>" data-article-id="<?php echo $article['ArticleId']; ?>" class="btn btn-default btnEnableArticle <?php if($article['Status']=='Active'){echo'disabled';} ?>" href="#"><span class="glyphicon glyphicon-ok"></span></button>
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
		$('.btnEnableArticle').click(function()
		{
			var status_th = $(this).data('status-th');
			$(this).attr('disabled', 'disabled');
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
	});
</script>