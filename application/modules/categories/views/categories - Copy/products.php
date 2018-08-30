<!-- product content wp -->
<div class="product-content-wp">
	<div class="container">
    	<div class="breadcrumb-wp">
            <ol class="breadcrumb">
              <li><a class="pink" href="/"><i class="glyphicon glyphicon-home"></i></a></li>
              <li class="active"><?php echo $category->name;?></li>
            </ol>
        </div>
        <div class="row">
        	<div class="col-lg-3">
            	<div class="left-column-block">
                    <div class="title-left-menu">
                        <h3>Danh mục sản phẩm</h3>
                    </div>
                    <div class="menu-left">
                        <div class="u-vmenu">
                            <ul>
								<?php category_left(5, $category->id);?>
                            </ul>
                        </div>
                    </div>
                </div>
                
            </div>	
            <div class="col-lg-9">
            	<div class="row list-product-wp block-product-scroll block-product-scroll-no">
					<?php foreach($products as $product){$_price = get_price_sale($product->price_1, $product->saleprice_1);?>
						<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    	<div class="item">
                            <div class="product-block-wp">
                                <div class="view view-fifth">
                                    <div class="icon-status">
                                        <?php if($product->label_new){?><p class="icon-new">New</p><?php }?>
										<?php if($_price['sale']){?><p class="icon-sale">Sale</p><?php }?>
                                        <p class="icon-bonus">Bonus</p>
                                    </div>
                                    <img src="<?php echo get_image_primary($product);?>" alt="" />
                                    <div class="mask">
                                        <div class="hover-icon-1">
                                            <p><a product-id="<?php echo $product->id;?>" data-toggle="modal" data-target="#quick-view"><i class="fa fa-search-plus" aria-hidden="true"></i></a></p>
                                            <p><a href="#!" data-toggle="modal" data-target="#wishlist"><i class="fa fa-heart-o" aria-hidden="true"></i></a></p>
                                            <p><a href="#!" data-toggle="modal" data-target="#cart-add"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a></p>
                                        </div>
                                        <div class="hover-icon-2">
                                            <ul>
                                                <li><p>Tặng khăng trải bàn</p></li>
                                                <li><p>Tặng khăng trải bàn</p></li>
                                                <li><p>Tặng khăng trải bàn</p></li>
                                                <li><p>Tặng khăng trải bàn</p></li>
                                            </ul>   
                                        </div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                                <div class="description top-pro-cen">
                                    <div class="name-product">
                                        <h3><a href="<?php echo url_product($product->slug);?>"><?php echo $product->name;?></a></h3>
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
                	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    	<div class="item">
                            <div class="product-block-wp">
                                <div class="view view-fifth">
                                    <div class="icon-status">
                                        <p class="icon-new">New</p>
                                        <p class="icon-sale">Sale</p>
                                        <p class="icon-bonus">Bonus</p>
                                    </div>
                                    <img src="images/product-1.jpg" alt="" />
                                    <div class="mask">
                                        <div class="hover-icon-1">
                                            <p><a href="#!" data-toggle="modal" data-target="#quick-view"><i class="fa fa-search-plus" aria-hidden="true"></i></a></p>
                                            <p><a href="#!" data-toggle="modal" data-target="#wishlist"><i class="fa fa-heart-o" aria-hidden="true"></i></a></p>
                                            <p><a href="#!" data-toggle="modal" data-target="#cart-add"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a></p>
                                        </div>
                                        <div class="hover-icon-2">
                                            <ul>
                                                <li><p>Tặng khăng trải bàn</p></li>
                                                <li><p>Tặng khăng trải bàn</p></li>
                                                <li><p>Tặng khăng trải bàn</p></li>
                                                <li><p>Tặng khăng trải bàn</p></li>
                                            </ul>   
                                        </div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                                <div class="description top-pro-cen">
                                    <div class="name-product">
                                        <h3><a href="#!">Kệ sách thời trang</a></h3>
                                    </div>
                                    <p class="product-price">150.000 VNĐ</p>
                                    <p class="product-price old">150.000 VNĐ</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    	<div class="item">
                            <div class="product-block-wp">
                                <div class="view view-fifth">
                                    <div class="icon-status">
                                        <p class="icon-new">New</p>
                                        <p class="icon-sale">Sale</p>
                                        <p class="icon-bonus">Bonus</p>
                                    </div>
                                    <img src="images/product-1.jpg" alt="" />
                                    <div class="mask">
                                        <div class="hover-icon-1">
                                            <p><a href="#!" data-toggle="modal" data-target="#quick-view"><i class="fa fa-search-plus" aria-hidden="true"></i></a></p>
                                            <p><a href="#!" data-toggle="modal" data-target="#wishlist"><i class="fa fa-heart-o" aria-hidden="true"></i></a></p>
                                            <p><a href="#!" data-toggle="modal" data-target="#cart-add"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a></p>
                                        </div>
                                        <div class="hover-icon-2">
                                            <ul>
                                                <li><p>Tặng khăng trải bàn</p></li>
                                                <li><p>Tặng khăng trải bàn</p></li>
                                                <li><p>Tặng khăng trải bàn</p></li>
                                                <li><p>Tặng khăng trải bàn</p></li>
                                            </ul>   
                                        </div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                                <div class="description top-pro-cen">
                                    <div class="name-product">
                                        <h3><a href="#!">Kệ sách thời trang</a></h3>
                                    </div>
                                    <p class="product-price">150.000 VNĐ</p>
                                    <p class="product-price old">150.000 VNĐ</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    	<div class="item">
                            <div class="product-block-wp">
                                <div class="view view-fifth">
                                    <div class="icon-status">
                                        <p class="icon-new">New</p>
                                        <p class="icon-sale">Sale</p>
                                        <p class="icon-bonus">Bonus</p>
                                    </div>
                                    <img src="images/product-1.jpg" alt="" />
                                    <div class="mask">
                                        <div class="hover-icon-1">
                                            <p><a href="#!" data-toggle="modal" data-target="#quick-view"><i class="fa fa-search-plus" aria-hidden="true"></i></a></p>
                                            <p><a href="#!" data-toggle="modal" data-target="#wishlist"><i class="fa fa-heart-o" aria-hidden="true"></i></a></p>
                                            <p><a href="#!" data-toggle="modal" data-target="#cart-add"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a></p>
                                        </div>
                                        <div class="hover-icon-2">
                                            <ul>
                                                <li><p>Tặng khăng trải bàn</p></li>
                                                <li><p>Tặng khăng trải bàn</p></li>
                                                <li><p>Tặng khăng trải bàn</p></li>
                                                <li><p>Tặng khăng trải bàn</p></li>
                                            </ul>   
                                        </div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                                <div class="description top-pro-cen">
                                    <div class="name-product">
                                        <h3><a href="#!">Kệ sách thời trang</a></h3>
                                    </div>
                                    <p class="product-price">150.000 VNĐ</p>
                                    <p class="product-price old">150.000 VNĐ</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    	<div class="item">
                            <div class="product-block-wp">
                                <div class="view view-fifth">
                                    <div class="icon-status">
                                        <p class="icon-new">New</p>
                                        <p class="icon-sale">Sale</p>
                                        <p class="icon-bonus">Bonus</p>
                                    </div>
                                    <img src="images/product-1.jpg" alt="" />
                                    <div class="mask">
                                        <div class="hover-icon-1">
                                            <p><a href="#!" data-toggle="modal" data-target="#quick-view"><i class="fa fa-search-plus" aria-hidden="true"></i></a></p>
                                            <p><a href="#!" data-toggle="modal" data-target="#wishlist"><i class="fa fa-heart-o" aria-hidden="true"></i></a></p>
                                            <p><a href="#!" data-toggle="modal" data-target="#cart-add"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a></p>
                                        </div>
                                        <div class="hover-icon-2">
                                            <ul>
                                                <li><p>Tặng khăng trải bàn</p></li>
                                                <li><p>Tặng khăng trải bàn</p></li>
                                                <li><p>Tặng khăng trải bàn</p></li>
                                                <li><p>Tặng khăng trải bàn</p></li>
                                            </ul>   
                                        </div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                                <div class="description top-pro-cen">
                                    <div class="name-product">
                                        <h3><a href="#!">Kệ sách thời trang</a></h3>
                                    </div>
                                    <p class="product-price">150.000 VNĐ</p>
                                    <p class="product-price old">150.000 VNĐ</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    	<div class="item">
                            <div class="product-block-wp">
                                <div class="view view-fifth">
                                    <div class="icon-status">
                                        <p class="icon-new">New</p>
                                        <p class="icon-sale">Sale</p>
                                        <p class="icon-bonus">Bonus</p>
                                    </div>
                                    <img src="images/product-1.jpg" alt="" />
                                    <div class="mask">
                                        <div class="hover-icon-1">
                                            <p><a href="#!" data-toggle="modal" data-target="#quick-view"><i class="fa fa-search-plus" aria-hidden="true"></i></a></p>
                                            <p><a href="#!" data-toggle="modal" data-target="#wishlist"><i class="fa fa-heart-o" aria-hidden="true"></i></a></p>
                                            <p><a href="#!" data-toggle="modal" data-target="#cart-add"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a></p>
                                        </div>
                                        <div class="hover-icon-2">
                                            <ul>
                                                <li><p>Tặng khăng trải bàn</p></li>
                                                <li><p>Tặng khăng trải bàn</p></li>
                                                <li><p>Tặng khăng trải bàn</p></li>
                                                <li><p>Tặng khăng trải bàn</p></li>
                                            </ul>   
                                        </div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                                <div class="description top-pro-cen">
                                    <div class="name-product">
                                        <h3><a href="#!">Kệ sách thời trang</a></h3>
                                    </div>
                                    <p class="product-price">150.000 VNĐ</p>
                                    <p class="product-price old">150.000 VNĐ</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    	<div class="item">
                            <div class="product-block-wp">
                                <div class="view view-fifth">
                                    <div class="icon-status">
                                        <p class="icon-new">New</p>
                                        <p class="icon-sale">Sale</p>
                                        <p class="icon-bonus">Bonus</p>
                                    </div>
                                    <img src="images/product-1.jpg" alt="" />
                                    <div class="mask">
                                        <div class="hover-icon-1">
                                            <p><a href="#!" data-toggle="modal" data-target="#quick-view"><i class="fa fa-search-plus" aria-hidden="true"></i></a></p>
                                            <p><a href="#!" data-toggle="modal" data-target="#wishlist"><i class="fa fa-heart-o" aria-hidden="true"></i></a></p>
                                            <p><a href="#!" data-toggle="modal" data-target="#cart-add"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a></p>
                                        </div>
                                        <div class="hover-icon-2">
                                            <ul>
                                                <li><p>Tặng khăng trải bàn</p></li>
                                                <li><p>Tặng khăng trải bàn</p></li>
                                                <li><p>Tặng khăng trải bàn</p></li>
                                                <li><p>Tặng khăng trải bàn</p></li>
                                            </ul>   
                                        </div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                                <div class="description top-pro-cen">
                                    <div class="name-product">
                                        <h3><a href="#!">Kệ sách thời trang</a></h3>
                                    </div>
                                    <p class="product-price">150.000 VNĐ</p>
                                    <p class="product-price old">150.000 VNĐ</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    	<div class="item">
                            <div class="product-block-wp">
                                <div class="view view-fifth">
                                    <div class="icon-status">
                                        <p class="icon-new">New</p>
                                        <p class="icon-sale">Sale</p>
                                        <p class="icon-bonus">Bonus</p>
                                    </div>
                                    <img src="images/product-1.jpg" alt="" />
                                    <div class="mask">
                                        <div class="hover-icon-1">
                                            <p><a href="#!" data-toggle="modal" data-target="#quick-view"><i class="fa fa-search-plus" aria-hidden="true"></i></a></p>
                                            <p><a href="#!" data-toggle="modal" data-target="#wishlist"><i class="fa fa-heart-o" aria-hidden="true"></i></a></p>
                                            <p><a href="#!" data-toggle="modal" data-target="#cart-add"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a></p>
                                        </div>
                                        <div class="hover-icon-2">
                                            <ul>
                                                <li><p>Tặng khăng trải bàn</p></li>
                                                <li><p>Tặng khăng trải bàn</p></li>
                                                <li><p>Tặng khăng trải bàn</p></li>
                                                <li><p>Tặng khăng trải bàn</p></li>
                                            </ul>   
                                        </div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                                <div class="description top-pro-cen">
                                    <div class="name-product">
                                        <h3><a href="#!">Kệ sách thời trang</a></h3>
                                    </div>
                                    <p class="product-price">150.000 VNĐ</p>
                                    <p class="product-price old">150.000 VNĐ</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    	<div class="item">
                            <div class="product-block-wp">
                                <div class="view view-fifth">
                                    <div class="icon-status">
                                        <p class="icon-new">New</p>
                                        <p class="icon-sale">Sale</p>
                                        <p class="icon-bonus">Bonus</p>
                                    </div>
                                    <img src="images/product-1.jpg" alt="" />
                                    <div class="mask">
                                        <div class="hover-icon-1">
                                            <p><a href="#!" data-toggle="modal" data-target="#quick-view"><i class="fa fa-search-plus" aria-hidden="true"></i></a></p>
                                            <p><a href="#!" data-toggle="modal" data-target="#wishlist"><i class="fa fa-heart-o" aria-hidden="true"></i></a></p>
                                            <p><a href="#!" data-toggle="modal" data-target="#cart-add"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a></p>
                                        </div>
                                        <div class="hover-icon-2">
                                            <ul>
                                                <li><p>Tặng khăng trải bàn</p></li>
                                                <li><p>Tặng khăng trải bàn</p></li>
                                                <li><p>Tặng khăng trải bàn</p></li>
                                                <li><p>Tặng khăng trải bàn</p></li>
                                            </ul>   
                                        </div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                                <div class="description top-pro-cen">
                                    <div class="name-product">
                                        <h3><a href="#!">Kệ sách thời trang</a></h3>
                                    </div>
                                    <p class="product-price">150.000 VNĐ</p>
                                    <p class="product-price old">150.000 VNĐ</p>
                                </div>
                            </div>
                        </div>
                    </div>
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