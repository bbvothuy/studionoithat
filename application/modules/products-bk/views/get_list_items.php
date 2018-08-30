    <?php
    $cartItems = GC::getCartItems();
    $options = CI::Orders()->getItemOptions(GC::getCart()->id);

    $charges = [];

    $charges['giftCards'] = [];
    $charges['coupons'] = [];
    $charges['tax'] = [];
    $charges['shipping'] = [];
    $charges['products'] = [];

    foreach ($cartItems as $item)
    {
        if($item->type == 'gift card')
        {
            $charges['giftCards'][] = $item;
            continue;
        }
        elseif($item->type == 'coupon')
        {
            $charges['coupons'][] = $item;
            continue;
        }
        elseif($item->type == 'tax')
        {
            $charges['tax'][] = $item;
            continue;
        }
        elseif($item->type == 'shipping')
        {
            $charges['shipping'][] = $item;
            continue;
        }
        elseif($item->type == 'product')
        {
            $charges['products'][] = $item;
        }
    }

    if(count($charges['products']) == 0)
    {
        echo '<script>location.reload();</script>';
    }

    foreach($charges['products'] as $product):

        $photo = theme_img('no_picture.png', lang('no_image_available'));
        $product->images = array_values(json_decode($product->images, true));

        if(!empty($product->images[0]))
        {
            foreach($product->images as $photo)
            {
                if(isset($photo['primary']))
                {
                    $primary = $photo;
                }
            }
            if(!isset($primary))
            {
                $tmp = $product->images; //duplicate the array so we don't lose it.
                $primary = array_shift($tmp);
            }

            $photo = '<img style="width:68px;" class="media-object" src="'.base_url('uploads/images/thumbnails/'.$primary['filename']).'"/>';
        }

        ?>
        <div class="media">
		  <div class="media-left">
			<a href="<?php echo url_product($product->slug);?>">
			  <?php echo $photo;?>
			  <!--<img class="media-object" src="/themes/default/assets/images/cart.jpg" alt="...">-->
			</a>
		  </div>
		  <div class="media-body">
			<h5 class="media-heading"><?php echo $product->name; ?></h5>
			<p>Số lượng: <?php echo $product->quantity;?></p>
			<span><?php echo format_currency($product->total_price * $product->quantity);?></span>
		  </div>
		</div>
        
		<?php /*
		<div class="col-nest">
			<div class="col" data-cols="1">
				<div class="cartItemName"><?php echo $product->name; ?></div>
			</div>
		</div>
		
		<?php if(!empty($product->coupon_code)):?>
			<div class="col-nest">
				<div class="col" data-cols="3/4">
					<small><?php echo lang('coupon').': '.$product->coupon_code;?></small>
				</div>
				<div class="col text-right text-red" data-cols="1/4">
					<strong><small><?php echo '-'.format_currency(($product->coupon_discount * $product->coupon_discount_quantity));?></small></strong>
				</div>
			</div>
		<?php endif;?>

		<div class="col-nest">
			<div class="col" data-cols="1/5">
				<?php echo $photo;?>
			</div>

			<div class="col" data-cols="4/5">
				<?php echo (!empty($product->sku))?'<div class="cartItemSku">'.lang('sku').': '.$product->sku.'</div>':''?>
				<?php
				if(isset($options[$product->id]))
				{
					foreach($options[$product->id] as $option):?>
						<div class="cartItemOption"><?php echo ($product->is_giftcard) ? lang('gift_card_'.$option->option_name) : $option->option_name;?> : <?php echo($option->price > 0)?'['.format_currency($option->price).']':'';?> <?php echo $option->value;?></div>
					<?php endforeach;
				}
				?>
			</div>
		</div>
		<div class="col-nest">
			<div class="col" data-cols="1/2">
				<strong><small><?php echo $product->quantity.' &times; '.format_currency($product->total_price)?></small></strong>
			</div>
			<div class="col text-right" data-cols="1/4">
				<?php if(CI::uri()->segment(1) == 'cart' && !$product->fixed_quantity): ?>
					<input class="input-sm quantityInput" style="margin:0;" <?php echo($product->fixed_quantity)?'disabled':''?> data-product-id="<?php echo $product->id;?>" data-orig-val="<?php echo $product->quantity ?>" id="qtyInput<?php echo $product->id;?>" value="<?php echo $product->quantity ?>" type="text">
				<?php else: ?>
					&times; <?php echo $product->quantity; ?>
				<?php endif;?>

				<div class="cartItemRemove">
					<a class="text-red" onclick="updateItem(<?php echo $product->id;?>, 0);" style="cursor:pointer"><?php echo lang('remove');?></a>
				</div>
			</div>
			<div class="col text-right" data-cols="1/4">
				<strong><small><?php echo format_currency($product->total_price * $product->quantity); ?></small></strong>
			</div>
		</div>
		*/?>
    <?php endforeach;?>

	<div class="cart-total">
	<h5>Tổng đơn hàng: <span class="red"><?php echo format_currency(GC::getGrandTotal());?></span></h5>
	</div>
	<div class="cart-button">
		<a href="/checkout" class="btn btn-danger form-control" style="color:white; background-color:#e91f6b">Thanh Toán</a>
	</div>
	<?php /*
    <?php if(count($charges['products']) > 0):?>

        <div class="cartSummaryTotals">
            <div class="col-nest">
                <div class="col" data-cols="2/3" data-medium-cols="2/3" data-small-cols="2/3">
                    <div class="cartSummaryTotalsKey"><?php echo lang('subtotal');?>:</div>
                </div>
                <div class="col" data-cols="1/3" data-medium-cols="1/3" data-small-cols="1/3">
                    <div class="cartSummaryTotalsValue"><?php echo format_currency(GC::getSubtotal());?></div>
                </div>
            </div>

        <?php if(count($charges['shipping']) > 0 || count($charges['tax']) > 0 ):?>

                <?php foreach($charges['shipping'] as $shipping):?>
                    <div class="col-nest">
                        <div class="col" data-cols="2/3" data-medium-cols="2/3" data-small-cols="2/3">
                            <div class="cartSummaryTotalsKey"><?php echo lang('shipping');?>: <?php echo $shipping->name; ?></div>
                        </div>
                        <div class="col" data-cols="1/3" data-medium-cols="1/3" data-small-cols="1/3">
                            <div class="cartSummaryTotalsValue">
                                <?php echo format_currency($shipping->total_price); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach;?>

                <?php foreach($charges['tax'] as $tax):?>
                    <div class="col-nest">
                        <div class="col" data-cols="2/3" data-medium-cols="2/3" data-small-cols="2/3">
                            <div class="cartSummaryTotalsKey"><?php echo lang('taxes');?>: <?php echo $tax->name; ?></div>
                        </div>
                        <div class="col" data-cols="1/3" data-medium-cols="1/3" data-small-cols="1/3">
                            <div class="cartSummaryTotalsValue">
                                <?php echo format_currency($tax->total_price); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach;?>
        <?php endif;?>

        <?php if(count($charges['giftCards']) > 0):?>
            </div>
            <?php foreach($charges['giftCards'] as $giftCard):?>
                <div class="cartItem">
                    <div class="col-nest">
                        <div class="col" data-cols="3/4">
                            <div class="cartItemName"><?php echo $giftCard->name; ?></div>
                            <small><?php echo $giftCard->description; ?><br>
                            <?php echo $giftCard->excerpt; ?></small>
                        </div>
                        <div class="col text-right" data-cols="1/4" data-medium-cols="1/4" data-small-cols="1/4" style="white-space:nowrap;">
                            <?php echo format_currency($giftCard->total_price); ?>
                            <div class="cartItemRemove">
                                <a class="text-red" onclick="updateItem(<?php echo $giftCard->id;?>, 0);" style="cursor:pointer"><?php echo lang('remove');?></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach;?>
            <div class="cartSummaryTotals">
        <?php endif;?>

            <div class="col-nest">
                <div class="col" data-cols="2/3" data-medium-cols="2/3" data-small-cols="2/3">
                    <div class="cartSummaryTotalsKey"><?php echo lang('grand_total');?>:</div>
                </div>
                <div class="col" data-cols="1/3" data-medium-cols="1/3" data-small-cols="1/3">
                    <div class="cartSummaryTotalsValue"><?php echo format_currency(GC::getGrandTotal());?></div>
                </div>
            </div>
        </div>
    <?php endif;?>

<?php 
<div class="media">
  <div class="media-left">
	<a href="#">
	  <img class="media-object" src="/themes/default/assets/images/cart.jpg" alt="...">
	</a>
  </div>
  <div class="media-body">
	<h5 class="media-heading">Áo Thun Nam</h5>
	<p>QLTY: 02</p>
	<span>150.000 VNĐ</span>
  </div>
</div>
<div class="media">
  <div class="media-left">
	<a href="#">
	  <img class="media-object" src="/themes/default/assets/images/cart.jpg" alt="...">
	</a>
  </div>
  <div class="media-body">
	<h5 class="media-heading">Áo Thun Nam</h5>
	<p>QLTY: 02</p>
	<span>150.000 VNĐ</span>
  </div>
</div>
<div class="media">
  <div class="media-left">
	<a href="#">
	  <img class="media-object" src="/themes/default/assets/images/cart.jpg" alt="...">
	</a>
  </div>
  <div class="media-body">
	<h5 class="media-heading">Áo Thun Nam</h5>
	<p>QLTY: 02</p>
	<span>150.000 VNĐ</span>
  </div>
</div>
<div class="cart-total">
	<h5>Tông đơn hàng: <span class="red">300.000 VNĐ</span></h5>
</div>
<div class="cart-button">
	<a href="/checkout" class="btn btn-danger form-control" style="color:white; background-color:#e91f6b">Thanh Toán</a>
</div>
*/?>