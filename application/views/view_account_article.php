<script type="text/javascript" src="<?php echo base_url();?>content/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">

$(document).ready(function (){
	$('#frmPostArticle').submit(function(){
		$('#article_content').val(tinyMCE.get('article_content').getContent());
		
		return true;
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
    <li class="active"><a data-toggle="tab" href="#new_article">New Article</a></li>
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
				echo form_input($article_title);
				echo "<br/><br/> Short Description: <br/><br/> ";
				echo form_input($article_desc);
				echo "<br/> <br/> Content: <br/><br/> ";
				echo form_textarea($article_content);
				
				?>
                
                <?php
				echo '<br/>';
				?>
                <div style="text-align: center;">
            	<?php
				echo form_submit($btn_submit);
				?>
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
                        <td class="cold-md-3"><?php echo $article['Status']; ?></td>
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
