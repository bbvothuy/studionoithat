<!-- product content wp -->
<style>
.select-option select{
    display: block;
    width: 100%;
    height: 34px;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;}
</style>
<div class="product-content-wp">
	<div class="container">
    	<div class="breadcrumb-wp">
            <ol class="breadcrumb">
              <li><a class="pink" href="#"><i class="glyphicon glyphicon-home"></i></a></li>
              <li class="active">Sản phẩm</li>
            </ol>
        </div>
        <div class="row">
        	<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            	<div class="left-column-block">
                    <div class="title-left-menu">
                        <h3>Danh mục sản phẩm</h3>
                    </div>
                    <div class="menu-left">
                        <div class="u-vmenu">
                            <ul>
                                <?php category_left(5, 0);?>
                            </ul>
                        </div>
                    </div>
                </div>
                
            </div>
			<?php $_price = get_price_sale($product->price_1, $product->saleprice_1);?>
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
            	<div class="quick-view-wp product-detail-wp">
                  <div class="row">
                    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                      <div class="slider-product-wp">
                        <div class="gallery">
                          <div class="full"> 
                            <img src="<?php echo get_image_primary($product);?>" /> 
                          </div>
                          <div class="clear"></div>
                          <div class="previews">
                            <ul>
                                <?php foreach($product->images as $key=>$image):?>
									<?php if($key == 0){?>
									<li><a href="#!" class="selected" data-full="/uploads/images/full/<?php echo $image['filename'];?>"><img src="/uploads/images/thumbnails/<?php echo $image['filename'];?>"></a></li>
									<?php }else{?>
									<li><a href="#!" data-full="/uploads/images/full/<?php echo $image['filename'];?>"><img src="/uploads/images/thumbnails/<?php echo $image['filename'];?>" /></a></li>
									<?php }?>
								<?php endforeach;?>
                            </ul> 
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
						<?php echo form_open('cart/add-to-cart', 'id="add-to-cart"');?>
						<input type="hidden" name="cartkey" value="<?php echo CI::session()->flashdata('cartkey');?>" />
						<input type="hidden" name="id" value="<?php echo $product->id?>"/>
                        <div class="des-product-wp">
                            <h3 class="title-des"><?php echo $product->name;?></h3>
							<?php if($product->quantity > 0){?><p class="status">Tình trạng : <span class="pink">Còn hàng</span></p><?php }?>
							<p class="status">Mã sản phẩm : <span class="pink"><?php echo $product->sku;?></span></p>                            
                            <hr>
                            <div class="product-price-block">
                                <?php if($_price['sale']){?>
									<p class="product-price"><?php echo format_currency($_price['price']);?></p>
									<p class="product-price old"><?php echo format_currency($_price['price_old']);?></p>
								<?php }else{?>
									<p class="product-price"><?php echo format_currency($_price['price']);?></p>
								<?php }?>
                            </div>
			
                            <hr>
							<div id="productAlerts"></div>
							
							
							
							
							<?php if(count($options) > 0): ?>
                <?php foreach($options as $option):
                    $required = '';
                    if($option->required)
                    {
                        $required = ' class="required"';
                    }
                    ?>
                        <div class="row select-option" style="margin-left:0px">
                            <div class="pull-left" data-cols="1/3" style="margin-right:10px;margin-top: 8px;">
                                <label<?php echo $required;?>><?php echo ($product->is_giftcard) ? lang('gift_card_'.$option->name) : $option->name;?></label>
                            </div>
                            <div class="pull-left form-group" data-cols="2/3">
                        <?php
                        if($option->type == 'checklist')
                        {
                            $value  = [];
                            if($posted_options && isset($posted_options[$option->id]))
                            {
                                $value  = $posted_options[$option->id];
                            }
                        }
                        else
                        {
                            if(isset($option->values[0]))
                            {
                                $value  = $option->values[0]->value;
                                if($posted_options && isset($posted_options[$option->id]))
                                {
                                    $value  = $posted_options[$option->id];
                                }
                            }
                            else
                            {
                                $value = false;
                            }
                        }

                        if($option->type == 'textfield'):?>
                            <input type="text" name="option[<?php echo $option->id;?>]" value="<?php echo $value;?>"/>
                        <?php elseif($option->type == 'textarea'):?>
                            <textarea name="option[<?php echo $option->id;?>]"><?php echo $value;?></textarea>
                        <?php elseif($option->type == 'droplist'):?>
                            <select name="option[<?php echo $option->id;?>]">
                                <!--<option value=""><?php echo lang('choose_option');?></option>-->

                            <?php foreach ($option->values as $values):
                                $selected   = '';
                                if($value == $values->id)
                                {
                                    $selected   = ' selected="selected"';
                                }?>

                                <option<?php echo $selected;?> value="<?php echo $values->id;?>">
                                    <?php if($product->is_giftcard):?>
                                        <?php echo($values->price != 0)?' (+'.format_currency($values->price).') ':''; echo lang($values->name);?>
                                    <?php else:?>
                                        <?php echo($values->price != 0)?' (+'.format_currency($values->price).') ':''; echo $values->name;?>
                                    <?php endif;?>
                                    
                                </option>

                            <?php endforeach;?>
                            </select>
                        <?php elseif($option->type == 'radiolist'):?>
                            <label class="radiolist">
                            <?php foreach ($option->values as $values):

                                $checked = '';
                                if($value == $values->id)
                                {
                                    $checked = ' checked="checked"';
                                }?>
                                <div>
                                    <input<?php echo $checked;?> type="radio" name="option[<?php echo $option->id;?>]" value="<?php echo $values->id;?>"/>
                                    <?php echo($values->price != 0)?'(+'.format_currency($values->price).') ':''; echo $values->name;?>
                                </div>
                            <?php endforeach;?>
                            </label>
                        <?php elseif($option->type == 'checklist'):?>
                            <label class="checklist"<?php echo $required;?>>
                            <?php foreach ($option->values as $values):

                                $checked = '';
                                if(in_array($values->id, $value))
                                {
                                    $checked = ' checked="checked"';
                                }?>
                                <div><input<?php echo $checked;?> type="checkbox" name="option[<?php echo $option->id;?>][]" value="<?php echo $values->id;?>"/>
                                <?php echo($values->price != 0 && $option->name != 'Buy a Sample')?'('.format_currency($values->price).') ':''; echo $values->name;?></div>
                            <?php endforeach; ?>
                            </label>
                        <?php endif;?>
                        </div>
                    </div>
                <?php endforeach;?>
            <?php endif;?>
			
			
			
			
                            <div class="form-inline button-product-detail">
                              <div class="form-group">
                                <label>Số lượng</label>
                                <input style="width:50px;" type="text" class="form-control width-50" value="1">
                              </div>
                              <div class="form-group">
                                <a class="btn btn-cart" onclick="addToCart($(this));" product-detail="1"><i class="fa fa-cart-plus"></i> Thêm vào giỏ hàng</a>
                              </div>
                              <div class="form-group">
                                <a class="btn btn-wishlist"><i class="fa fa-heart-o"></i></a>
                              </div>
                            </div>
                            <hr>
                            <div class="short-des">
                                <?php echo html_entity_decode($product->description);?>
                            </div>
                        </div>
						</form>
                    </div>
                  </div>
                </div>
            </div>
        </div>
        <div class="product-same">
		<?php if(!empty($product->related_products)):?>
			<div class="feature-title-wp text-center">
                <h3 class="text-uppercase">Sản phẩm liên quan</h3>
                <p><img src="/themes/default/assets/images/icon-title.jpg"></p>
            </div>
			<?php
			$relatedProducts = [];
			foreach($product->related_products as $related)
			{
				$related->images    = json_decode($related->images, true);
				$relatedProducts[] = $related;
			}
			//echo '<pre>'; print_r($product->related_products);
			//\GoCart\Libraries\View::getInstance()->show('categories/products', ['products'=>$relatedProducts]); ?>
			<div class="block-product-scroll block-product-scroll-no margin-tb">
                <div class="owl-carousel3">
					<?php foreach($relatedProducts as $tmp_product){$_price = get_price_sale($tmp_product->price_1, $tmp_product->saleprice_1);?>
					
					
					<div class="item">
                        <div class="product-block-wp">
                            <div class="view view-fifth">
                                <div class="icon-status">
                                    <?php if($tmp_product->label_new){?><p class="icon-new">New</p><?php }?>
									<?php if($_price['sale']){?><p class="icon-sale">Sale</p><?php }?>
                                    <!--<p class="icon-bonus">Bonus</p>-->
                                </div>
                                <img src="<?php echo get_image_primary_3($tmp_product->images);?>" alt="" />
                                <div class="mask">
                                    <div class="hover-icon-1">
                                        <p><a product-id="<?php echo $tmp_product->id?>" data-toggle="modal" data-target="#quick-view"><i class="fa fa-search-plus" aria-hidden="true"></i></a></p>
                                        <p><a class="add-wishlist" href="#!" data-toggle="modal" data-target="#wishlist"><i class="fa fa-heart-o" aria-hidden="true"></i></a></p>
                                        <p><a href="#!" data-toggle="modal" data-target="#cart-add"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a></p>
                                    </div>
									<!--
                                    <div class="hover-icon-2">
                                        <ul>
                                            <li><p>Tặng khăng trải bàn</p></li>
                                            <li><p>Tặng khăng trải bàn</p></li>
                                            <li><p>Tặng khăng trải bàn</p></li>
                                            <li><p>Tặng khăng trải bàn</p></li>
                                        </ul>   
                                    </div>
									-->
                                </div>
                            </div>
                            <div class="clear"></div>
                            <div class="description top-pro-cen">
                                <div class="name-product">
                                    <h3><a href="<?php echo url_product($tmp_product->slug);?>"><?php echo $tmp_product->name;?></a></h3>
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
					<?php }?>
				</div>
			</div>

		<?php endif;?>

		</div>
    </div>
</div>
<!-- end product content wp -->