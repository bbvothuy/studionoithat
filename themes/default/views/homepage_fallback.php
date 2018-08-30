<!-- slider -->
<div class="slider-content">	
	<div id="slider-banner" class="slider-pro">
		<?php \CI::Banners()->show_collection(1);?>                    
	</div>    
</div>
<!-- end slider -->

<!-- content home block -->
<section class="content-block">
	<div class="container">
		<?php if($cat_top_home){ foreach($cat_top_home as $cate){ if(!empty($cate->products)){?>
		<div class="title-content">  	
        	<a title="<?php echo $cate->name;?>" href="<?php echo url_cate($cate->slug);?>"><h1><?php echo $cate->name;?></h1></a>
            <div class="line"></div>
        </div>
		<div class="block-product-scroll block-product-scroll-no margin-tb">
            <div class="row list-product-wp block-product-scroll block-product-scroll-no">
				<?php foreach($cate->products as $product){$_price = get_price_sale($product->price, $product->saleprice, $product->sale_start_date, $product->sale_end_date);?>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12"><div class="item">
                    <div class="product-block-wp">
                        <div class="view view-fifth">
                            <div class="icon-status">
								<?php if($product->label_new){?><p class="icon-new">New</p><?php }?>
                                <?php if($_price['sale']){?><p class="icon-sale">Sale</p><?php }?>
                                <?php if($product->product_type == 1 && isset($product->bonus_product) && is_array($product->bonus_product) && count($product->bonus_product) > 0){?>
									<p class="icon-bonus">Bonus</p>
								<?php }?>
                            </div>
                            <div class="image-prod-list">
								<a title="<?php echo $product->name;?>" href="<?php echo url_product($product->slug, $cate->slug);?>">
									<img title="<?php echo $product->name;?>" src="<?php echo get_image($product->images);?>" alt="<?php echo $product->name;?>" />
								</a>
							</div>
                            <div class="">
                                <div class="hover-icon-1">
                                    <p>
										<a product-id="<?php echo $product->id;?>" data-toggle="modal" data-target="#quick-view">
											<i class="fa fa-search-plus" aria-hidden="true"></i>
										</a>
									</p>
                                    <p>
										<a class="add-wishlist" product-id="<?php echo $product->id;?>" data-toggle="modal" data-target="#wishlist">
										<i class="fa fa-heart-o" aria-hidden="true"></i>
										</a>
									</p>
                                    <p>
										<a product-id="<?php echo $product->id;?>" data-toggle="modal" data-target="#cart-add">
											<i class="fa fa-shopping-cart" aria-hidden="true"></i>
										</a>
									</p>
                                </div>
								<?php if($product->product_type == 1 && isset($product->bonus_product) && is_array($product->bonus_product) && count($product->bonus_product) > 0){?>
								<div class="hover-icon-2">
									<ul>
										<?php foreach($product->bonus_product as $bonus){?>
										<li><p><?php echo $bonus->bonus_name;?></p></li>
										<?php }?>
									</ul>   
								</div>
								<?php }?>
                            </div>
                        </div>
                        <div class="clear"></div>
                        <div class="description top-pro-cen">
                            <div class="name-product">
                                <h3><a title="<?php echo $product->name;?>" href="<?php echo url_product($product->slug, $cate->slug);?>"><?php echo $product->name;?></a></h3>
                            </div>
							<?php if($_price['sale']){?>
								<p class="product-price"><?php echo format_currency($_price['price']);?></p>
								<p class="product-price old"><?php echo format_currency($_price['price_old']);?></p>
							<?php }else{?>
								<p class="product-price"><?php echo format_currency($_price['price']);?></p>
							<?php }?>
                        </div>
                    </div>
                </div></div>
				<?php }?>
            
			</div>
        </div>
		
		
		<?php }}}?>
    	
		<!-- block tin tuc -->
        <div class="title-content">  	
        	<h1>Blog</h1>
            <div class="line"></div>
        </div>
		<?php $news = \CI::Pages()->get_pages(1, 6);?>
        <div class="block-product-scroll block-product-scroll-no margin-tb">
            <div class="owl-carousel2">
				<?php foreach($news as $item){?>
				<div class="item">
                    <div class="content-news-wp">
                    	<div class="h-news-img">
                        	<a href="<?php echo url_news($item->slug);?>" title="<?php echo $item->title;?>"><img alt="<?php echo $item->title;?>" src="<?php echo get_src_img($item->image, 'medium');?>"></a>
                        </div>
                        <h4><a href="<?php echo url_news($item->slug);?>"><?php echo $item->title;?></a></h4>
                        <!--<p class="news-calendar"><i class="glyphicon glyphicon-calendar"></i> 20/10/2016</p>
                        <p>Tiểu cảnh sân vườn xanh tươi, có hồ phun nước, hoa sắc đua nhau nở.</p>-->
                        <p><a title="<?php echo $item->title;?>" href="<?php echo url_news($item->slug);?>" class="readmore-news">Xem chi tiết</a></p>
                    </div>
                </div>
				<?php }?>
			</div>
            <div class="button-readmore">
            	<a href="<?php echo url_news('tin-tuc');?>">Xem thêm</a>
            </div>
        </div>
    </div>
</section>
<!-- end content home block -->
<?php /*
<!-- newsletter content -->
<section class="newsletter-wp">
	<div id="title" class="slide header">
    	<div class="newsletter">
        	<div class="title-newsletter">
            	<img src="/themes/default/assets/images/icon-newletter.png" alt="">
            	<h3>NEWSLETTER</h3>
          	</div>
            <p>Đăng ký thành viên đễ tích lũy nhận ưu đãi chiếc khấu lên đến 5%</p>
            <div class="form-inline form-newsletters">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Your Email Address" name="email_newsletter">
              </div>
              <button type="submit" id="registry_newsletter" class="btn btn-default">Đăng ký</button>
            </div>
        </div>
    </div>
</section>
<!-- end newsletter content -->
*/?>

<?php /*
<!-- content khach hang -->
<section class="h-customer-wp">
	<div class="container">
    	<div class="row h-banner">
        	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="footer-bag">
                	<img src="/themes/default/assets/images/dl-1.jpg" alt="">
                    <h4>Giao hàng nhanh & an toàn</h4>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="footer-bag">
                	<img src="/themes/default/assets/images/dl-2.jpg" alt="">
                    <h4>Giao hàng nhanh & an toàn</h4>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="footer-bag">
                	<img src="/themes/default/assets/images/dl-3.jpg" alt="">
                    <h4>Giao hàng nhanh & an toàn</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="h-custom">
    	<div class="banner-content-2">
        	<div class="box_img bn1">
                <div class="view view-fifth">
                    <img alt="" src="/themes/default/assets/images/kh-1.jpg">
                    <div class="mask">
                        <div class="kh-hover-wp">
                            <h4>Khach hang 1</h4>
                            <p>Thong tin</p>
                            <a href="#">Xem chi tiet</a>
                        </div>
                    </div>
                </div>
            </div>
        	<div class="box_img bn2">
            	<div class="view view-fifth">
                    <img alt="" src="/themes/default/assets/images/kh-2.jpg">
                    <div class="mask">
                        <div class="kh-hover-wp">
                            <h4>Khach hang 1</h4>
                            <p>Thong tin</p>
                            <a href="#">Xem chi tiet</a>
                        </div>
                    </div>
                </div>
            </div>
        	<div class="box_img bn3">
            	<div class="view view-fifth">
                    <img alt="" src="/themes/default/assets/images/kh-3.jpg">
                    <div class="mask">
                        <div class="kh-hover-wp">
                            <h4>Khach hang 1</h4>
                            <p>Thong tin</p>
                            <a href="#">Xem chi tiet</a>
                        </div>
                    </div>
                </div>
            </div>
        	<div class="box_img bn4">
            	<div class="view view-fifth">
                    <img alt="" src="/themes/default/assets/images/kh-4.jpg">
                    <div class="mask">
                        <div class="kh-hover-wp">
                            <h4>Khach hang 1</h4>
                            <p>Thong tin</p>
                            <a href="#">Xem chi tiet</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</section>
*/?>
<!-- end content khach hang -->
