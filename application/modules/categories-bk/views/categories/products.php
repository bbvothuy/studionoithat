<!-- product content wp -->
<div class="product-content-wp">
	<div class="container">
    	<div class="breadcrumb-wp">
            <ol class="breadcrumb">
              <li><a class="pink" href="/"><i class="glyphicon glyphicon-home"></i></a></li>
              <?php if(isset($category) && $category->name != '') {?><li class="active"><?php echo @$category->name;?></li><?php }?>
            </ol>
        </div>
        <div class="row">
        	<div class="col-lg-3 category-list">
            	<div class="left-column-block">
                    <div class="title-left-menu">
                        <h3>Danh mục sản phẩm</h3>
                    </div>
                    <div class="menu-left">
                        <div class="u-vmenu">
                            <ul>
								<?php if(isset($category->id))category_left(5, $category->id);else category_left(5, 0);?>
                            </ul>
                        </div>
                    </div>
                </div>
                
            </div>	
            <div class="col-lg-9">
				<?php if(isset($search) && $search == true){?>
				<div class="row col-xs-12" style="font-size: 18px; margin-bottom: 10px">
					Kết quả được tìm thấy
				</div>
				<?php }?>
				<?php if(!isset($cate_slug)){
					$cate_slug = '';}
				?>
            	<div class="row list-product-wp block-product-scroll block-product-scroll-no">
					<?php foreach($products as $product){$_price = get_price_sale($product->price, $product->saleprice, $product->sale_start_date, $product->sale_end_date);?>
						<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    	<div class="item">
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
										<a title="<?php echo $product->name;?>" href="<?php echo url_product($product->slug, $cate_slug);?>">
											<img src="<?php echo get_image_primary($product, 'small');?>" alt="<?php echo $product->name;?>" />
										</a>
									</div>
                                    <div class="">
                                        <div class="hover-icon-1">
                                            <p><a product-id="<?php echo $product->id;?>" data-toggle="modal" data-target="#quick-view"><i class="fa fa-search-plus" aria-hidden="true"></i></a></p>
                                            <p><a class="add-wishlist" product-id="<?php echo $product->id;?>" data-toggle="modal" data-target="#wishlist"><i class="fa fa-heart-o" aria-hidden="true"></i></a></p>
                                            <p><a product-id="<?php echo $product->id;?>" data-toggle="modal" data-target="#cart-add"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a></p>
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
                                        <h3><a title="<?php echo $product->name;?>" href="<?php echo url_product($product->slug, $cate_slug);?>"><?php echo $product->name;?></a></h3>
                                    </div>
									<?php if($_price['sale']){?>
										<p class="product-price"><?php echo format_currency($_price['price']);?></p>
										<p class="product-price old"><?php echo format_currency($_price['price_old']);?></p>
									<?php }else{?>
										<p class="product-price"><?php echo format_currency($_price['price']);?></p>
									<?php }?>
                                </div>
                            </div>
                        </div>
                    </div>
					<?php }?>
					
				</div>
                <div class="pagination-wp">
                    <nav aria-label="Page navigation">
					<?php echo CI::pagination()->create_links();?>                      
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end product content wp -->

<?php /*
<?php if(count($products) == 0):?>

    <h2 style="margin:50px 0px; text-align:center; line-height:30px;">
        <?php echo lang('no_products');?>
    </h2>

<?php else:?>

    <div class="col-nest categoryItems element">
    <?php foreach($products as $product):?>
        <div class="col" data-cols="1/4" data-medium-cols="1/2" data-small-cols="1">
            <?php
            $photo  = theme_img('no_picture.png');

            if(!empty($product->images[0]))
            {
                $primary    = $product->images[0];
                foreach($product->images as $photo)
                {
                    if(isset($photo['primary']))
                    {
                        $primary    = $photo;
                    }
                }

                $photo  = base_url('uploads/images/medium/'.$primary['filename']);
            }
            ?>
            <div onclick="window.location = '<?php echo site_url('/product/'.$product->slug); ?>'" class="categoryItem" >
                <?php if((bool)$product->track_stock && $product->quantity < 1 && config_item('inventory_enabled')):?>
                    <div class="categoryItemNote yellow"><?php echo lang('out_of_stock');?></div>
                <?php elseif($product->saleprice > 0):?>
                    <div class="categoryItemNote red"><?php echo lang('on_sale');?></div>
                <?php endif;?>
                
                <div class="previewImg"><img src="<?php echo $photo;?>"></div>

                <div class="categoryItemDetails">
                    <?php echo $product->name;?>
                </div>

                <?php if(!$product->is_giftcard): //do not display this if the product is a giftcard?>
                <div class="categoryItemHover">
                    <div class="look">
                        <?php echo ( $product->saleprice>0?format_currency($product->saleprice):format_currency($product->price) );?>
                    </div>
                </div>
                <?php endif;?>

            </div>
        </div>
    <?php endforeach;?>
    </div>

<?php endif;?>
*/?>