<div id="mm-0" class="mm-page mm-slideout">
	<div class="product-content-wp">
		<div class="container">
			<div class="breadcrumb-wp">
				<ol class="breadcrumb">
				  <li><a class="pink" href="#"><i class="glyphicon glyphicon-home"></i></a></li>
				  <li class="active">Tin tức</li>
				</ol>
			</div>		
			<div class="row block-news">
			
				<?php $news = \CI::Pages()->get_pages(1);?>
				<?php foreach($news as $item){?>
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
				
				<!-- pagination -->
				<!--
				<div class="pagination-wp">
					<nav aria-label="Page navigation">
					  <ul class="pagination">
						<li>
						  <a href="#" aria-label="Previous">
							<span aria-hidden="true">«</span>
						  </a>
						</li>
						<li><a href="#">1</a></li>
						<li><a href="#">2</a></li>
						<li><a href="#">3</a></li>
						<li><a href="#">4</a></li>
						<li><a href="#">5</a></li>
						<li>
						  <a href="#" aria-label="Next">
							<span aria-hidden="true">»</span>
						  </a>
						</li>
					  </ul>
					</nav>
				</div>
				-->
			</div>
		</div>
	</div>
</div>