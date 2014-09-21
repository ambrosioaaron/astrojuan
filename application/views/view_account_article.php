<script type="text/javascript" src="<?php echo base_url();?>content/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">

$(document).ready(function (){
	$('#frmPostArticle').submit(function(){
		$('#article_content').val(tinyMCE.get('article_content').getContent());
		
		return true;
	});
	
	$('.astro-article-edit').click(function () {
		$('.astro-article-tab-new').click();
		$('#article_id').val($(this).data('article-id'));
		
		$.ajax({
			 type: "GET",
			 url: "<?php echo base_url();?>account/article_edit/", 
			 data: { article_id: $(this).data('article-id'), article_owner_id: $(this).data('article-owner') },
			 success: function(data){
				 if(data!='Transaction Failed')
				 {
					 $('#article_title').val(data['ArticleTitle']);
					 $('#article_desc').val(data['ArticleShortDesc']);
					 tinyMCE.get('article_content').setContent(data['ArticleContent']);
				 }
			}
		});
	});
	
	$('.astro-article-disable').click(function(){
		$(this).parent().parent().find('.astro-article-edit').hide();
		$(this).parent().parent().find('.astro-article-disable').hide();
		
		var status_td = $(this).data('status-td');
		$(this).attr('disabled', 'disabled');
		$('#' + status_td).text('Updating...');
		$.ajax({
			 type: "GET",
			 url: "<?php echo base_url();?>account/article_disable/", 
			 data: { article_id: $(this).data('article-id'), article_owner_id: $(this).data('article-owner') },
			 success: function(data){
				 if(data!='Transaction Failed')
				 {
					 $('#' + status_td).text('Deleted');
				 }
			}
		});
	});
	
});

tinymce.init({
    selector: "textarea",
    theme: "modern",
    plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor colorpicker textpattern"
    ],
    toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
    toolbar2: "print preview media | forecolor backcolor emoticons",
    image_advtab: true,
    templates: [
        {title: 'Test template 1', content: 'Test 1'},
        {title: 'Test template 2', content: 'Test 2'}
    ]
});
</script>

<style>
	
	.table > tbody > tr > th,
	.table > tfoot > tr > td {
	  border-top: 1px solid #EEEEEE;
	}
	.nav-tabs
	{
		border-color: #008037;
	}

	.nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus
	{
		background-color: #EEE;
		border-top: solid 1px #008037;
		border-left: solid 1px #008037;
		border-right: solid 1px #008037;
		border-right: solid 1px #008037;
	}
	
	.nav-tabs > li > a:hover
	{
		background-color: #EEE;
		border-bottom: solid 1px #008037;
	}
</style>
<div class="jumbotron">

<ul class="nav nav-tabs">
    <li class="active"><a class='astro-article-tab-new' data-toggle="tab" href="#new_article">New Article</a></li>
    <li><a data-toggle="tab" href="#my_article_list">My Article List</a></li>
</ul>
	<div class="tab-content">
        <div id="new_article" class="tab-pane fade in active">
        	<br/>
            <?php
                    
				echo form_open('/account/articles', $form_attribute);
	
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
				
				echo "Title: <br/><br/> ";
				echo form_input($article_id);
				echo form_input($article_title);
				echo "<br/><br/> Short Description: <br/><br/> ";
				echo form_input($article_desc);
				echo "<br/> <br/> Content: <br/><br/> ";
				echo form_textarea($article_content);
				
				?>
                <br/>
                <div class="row">
                	<div class="col-md-2">
                    	<?php echo $captcha; ?>
                    </div>
                    <div class="col-md-4">
                    	<?php echo form_input($captchaAttr); ?>
                    </div>
                    <div class="col-md-6" style="text-align: right;">
						<?php echo form_submit($btn_submit); ?>
                        <input type="button" class="astro-article-edit-cancel btn btn-default" value="Cancel" />
                    </div>
                </div>
                
				<?php
				echo form_close();
			?>
        </div>
        <div id="my_article_list" class="tab-pane fade">
        	<table class="table">
            	<tr>
                	<th class="col-md-7">Article</th>
                    <th class="col-md-3">Status</th>
                    <th class="cold-md-1"></th>
                    <th class="cold-md-1"></th>
                </tr>
                
                <?php
                
                	foreach($articles as $article)
					{
				?>
                	<tr>
                    	<td class="cold-md-7 astro-article"><p><?php echo $article['ArticleTitle']; ?></p></td>
                        <td class="cold-md-3" id="astro-article-status<?php echo $article['ArticleId']; ?>"><?php echo $article['Status']; ?></td>
                        <td class="cold-md-1">
                        <button class="btn btn-default astro-article-edit" href="#" data-article-owner="<?php echo $article['CreatedBy']; ?>" data-article-id="<?php echo $article['ArticleId']; ?>"><span class="glyphicon glyphicon-pencil"></span></button>
                        </td>
                        <td class="cold-md-1">
                        <button class="btn btn-default astro-article-disable" data-status-td="astro-article-status<?php echo $article['ArticleId']; ?>" data-article-owner="<?php echo $article['CreatedBy']; ?>" data-article-id="<?php echo $article['ArticleId']; ?>" href="#"><span class="glyphicon glyphicon-ban-circle"></span></button>
                        </td>
                    </tr>
                <?php
					}
                
                ?>
            </table>
        </div>
    </div>
    
</div>
