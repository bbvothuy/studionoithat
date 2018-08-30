<div id="mm-0" class="mm-page mm-slideout"><div class="product-content-wp">
	<div class="product-content-wp">
		<div class="container">
			<div class="breadcrumb-wp">
				<ol class="breadcrumb">
				  <li><a class="pink" href="/"><i class="glyphicon glyphicon-home"></i></a></li>
				  <?php if($page->parent_id == 1){?>
					<li><a href="<?php echo url_news('tin-tuc');?>">Blog</a></li>
				  <?php }?>
				  <li class="active"><?php echo $page_title;?></li>
				</ol>
			</div>
			<div class="row block-news">
				<div class="postWrapper col-sm-12" style="margin-bottom: 0px;">
					<?php
						echo (new content_filter($page->content))->display();
					?>
				  <div class="clear"></div>
			  </div>
			</div>
			<hr/>

			<?php if(isset($new_list) && count($new_list) > 0){?>
			<div class="row block-news">
				<div style="text-align: center"><h3>BÀI VIẾT KHÁC</h3></div>
				<?php foreach($new_list as $item){?>
					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
						<div class="item">
							<div class="content-news-wp">
								<div class="h-news-img">
									<a href="<?php echo url_news($item->slug);?>"><img src="<?php echo get_src_img($item->image, 'medium');?>"></a>
								</div>
								<h4><a href="<?php echo url_news($item->slug);?>"><?php echo $item->title;?></a></h4>
								<p><a href="<?php echo url_news($item->slug);?>" class="readmore-news">Xem chi tiết</a></p>
							</div>
						</div>
					</div>
				<?php }?>
			</div>
			<?php }?>

		</div>
	</div>
</div>
<?php /*
<?php if($page_title):?>
    <div class="page-header">
        <h1><?php echo $page_title;?></h1>
    </div>
<?php endif;?>

<?php
echo (new content_filter($page->content))->display();
?>
*/?>