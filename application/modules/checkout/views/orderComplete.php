<link href="/themes/default/assets/css/gumbo/grid.css" type="text/css" rel="stylesheet" />
<link href="/themes/default/assets/css/gumbo/forms.css" type="text/css" rel="stylesheet" />
<style>
.orderPhoto img{
	width:100%;
	max-width:120px;
}
.cartItem, .orderItem .col-nest {
    padding: 15px;
    border-top: 3px solid #e0e0e0;
}
.cartSummaryTotals {
    padding: 15px;
    border-top: 1px solid #e0e0e0;
    text-align: right;
}
.cartPromotions {
    padding: 15px;
    background-color: #fafafa;
    border-top: 1px solid #e0e0e0;
}
#addressFormWrapper .page-header{
	padding-bottom: 0;
    margin: 0;
}
#addressFormWrapper .page-header h3{
	margin-top: 0;
    margin-bottom: 10px;
}
</style>
<div class="product-content-wp">
	<div class="container">
    	<div class="breadcrumb-wp">
            <ol class="breadcrumb">
              <li><a class="pink" href="#"><i class="glyphicon glyphicon-home"></i></a></li>
              <li class="active">Đơn hàng số: <?php echo $order->invoice_number;//echo $order->order_number;?></li>
            </ol>
        </div>
		<div class="">
			<div>
				<p>Quý khách đã đặt hàng thành công.</p>
				<p>Chúng tôi sẽ liện hệ lại quý khách để xác nhận thông tin.</p>
				<p>Thời gian giao hàng không quá 6 ngày làm việc.</p>
				<p>Cám ơn quý khách đã mua hàng chúng tôi.</p>
			</div>
			<div class="col" data-cols="1/2">

				<?php
				$charges = [];

				$charges['giftCards'] = [];
				$charges['coupons'] = [];
				$charges['tax'] = [];
				$charges['shipping'] = [];
				$charges['products'] = [];

				foreach ($order->items as $item)
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
				?>

				<?php foreach($charges['products'] as $product):

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

						$photo = '<img src="'.base_url('uploads/images/full/'.$primary['filename']).'"/>';
					}
					?>
					
					<div class="orderItem">
						<div class="col-nest">
							<div class="col" data-cols="2/3" data-medium-cols="2/3" data-small-cols="2/3">
								<div class="orderPhoto">
									<?php echo $photo;?>
									<?php echo (!empty($product->sku))?'<div class="orderItemSku">'.lang('sku').': '.$product->sku.'</div>':''?>
								</div>
								<div class="orderItemDetails">
									<div class="orderItemName"><a href="<?php echo site_url(PRODUCT.'/'.$product->slug);?>"><?php echo $product->name; ?></a></div>
									<div class="orderItemDescription">
										<?php
										if(isset($order->options[$product->id])):

											foreach($order->options[$product->id] as $option):?>
												<div class="orderItemOption"><strong><?php echo ($product->is_giftcard) ? lang('gift_card_'.$option->option_name) : $option->option_name;?> :</strong> <?php echo($option->price > 0)?'['.format_currency($option->price).']':'';?> <?php echo $option->value;?></div>
											<?php endforeach;

										endif;

										if(isset($order->files[$product->id]))
										{
											foreach($order->files[$product->id] as $file)
											{
												if($file->max_downloads == 0 || $file->downloads_used < $file->max_downloads)
												{
													echo '<div class="orderCompleteFileDownload">'.anchor('digital-products/download/'.$file->id.'/'.$file->order_id, '<i class="icon-chevron-down"></i>', 'class="btn input-xs"');
													echo ' '.$file->title.' <small>';
													if($file->max_downloads > 0)
													{
														echo ' '.str_replace('{quantity}', ($file->max_downloads - $file->downloads_used), lang('downloads_remaining'));
													}
													else
													{
														echo ' '.str_replace('{quantity}', '&infin;', lang('downloads_remaining'));
													}
													echo '</small></div>';
												}
											}
										}
										?>
									</div>
									
									<?php $bonus_type = 1; $str_bonus_name = '';
										if($product->product_type == 1 && $product->bonus_product != ''){
											$bonus = json_decode($product->bonus_product);
											if(is_array($bonus)){?>
												<?php foreach($bonus as $bonus_detail){
													if($bonus_detail->bonus_type == 0){
														$bonus_type = 0;
														$str_bonus_name = $str_bonus_name . '<div><b><i>'.$bonus_detail->bonus_name.'</i></b></div>';
													}
												}?>	
									<?php } }?>
									
									<?php if($bonus_type == 0 && $str_bonus_name !=''){
										echo $str_bonus_name;
									}?>
									
									<?php $str_combo_name = '';
										if($product->product_type == 2 && $product->combo_product != ''){
											$combo = json_decode($product->combo_product);
											if(is_array($combo)){?>
												<?php foreach($combo as $combo_detail){
													if($str_combo_name == ''){
														$str_combo_name = 'Bộ combo gồm: '.'<a href="/product/'.$combo_detail->slug.'" target="_blank">'.$combo_detail->name.'</a>';
													}
													else{
														$str_combo_name = $str_combo_name . ', '.'<a href="/product/'.$combo_detail->slug.'" target="_blank">'.$combo_detail->name.'</a>';
													}
												}?>	
									<?php } }?>
									
									<?php if($str_combo_name !=''){
										echo $str_combo_name;
									}?>
					
								</div>
							</div>
							<div class="col" data-cols="1/3" data-medium-cols="1/3" data-small-cols="1/3">
								<div class="orderPrice">
									<div class="orderItemQuantity">(<?php echo $product->quantity.'  &times; '.format_currency($product->total_price);?>)</div>
									<?php if(!empty($product->coupon_code)):?><div class="orderItemCoupon"><?php echo lang('coupon');?> <span class="nowrap"><?php echo '-'.format_currency(($product->coupon_discount * $product->coupon_discount_quantity));?></span></div><?php endif;?>

									<?php echo format_currency( ($product->total_price * $product->quantity) - ($product->coupon_discount * $product->coupon_discount_quantity) ); ?>
								</div>
							</div>
						</div>
					</div>

				<?php endforeach;?>

					<div class="cartSummaryTotals">
						<div class="col-nest">
							<div class="col" data-cols="2/3" data-medium-cols="2/3" data-small-cols="2/3">
								<div class="cartSummaryTotalsKey"><?php echo lang('subtotal');?>:</div>
							</div>
							<div class="col" data-cols="1/3" data-medium-cols="1/3" data-small-cols="1/3">
								<div class="orderTotalsValue"><?php echo format_currency($order->subtotal);?></div>
							</div>
						</div>

						<?php if(count($charges['shipping']) > 0 || count($charges['tax']) > 0 ):?>
							<?php foreach($charges['shipping'] as $shipping):?>
								<div class="col-nest">
									<div class="col" data-cols="2/3" data-medium-cols="2/3" data-small-cols="2/3">
										<div class="cartSummaryTotalsKey"><?php echo lang('shipping');?>: <?php echo $shipping->name; ?></div>
									</div>
									<div class="col" data-cols="1/3" data-medium-cols="1/3" data-small-cols="1/3">
										<div class="orderTotalsValue"><?php echo format_currency($shipping->total_price); ?></div>
									</div>
								</div>
							<?php endforeach;?>

							<?php foreach($charges['tax'] as $tax):?>
								<div class="col-nest">
									<div class="col" data-cols="2/3" data-medium-cols="2/3" data-small-cols="2/3">
										<div class="cartSummaryTotalsKey"><?php echo lang('taxes');?>: <?php echo $tax->name; ?></div>
									</div>
									<div class="col" data-cols="1/3" data-medium-cols="1/3" data-small-cols="1/3">
										<div class="orderTotalsValue"><?php echo format_currency($tax->total_price); ?></div>
									</div>
								</div>
							<?php endforeach;?>
						<?php endif;?>

						<?php if(count($charges['giftCards']) > 0):?>

							<?php foreach($charges['giftCards'] as $giftCard):?>
								<div class="col-nest">
									<div class="col" data-cols="2/3" data-medium-cols="2/3" data-small-cols="2/3">
										<div class="cartSummaryTotalsKey"><?php echo $giftCard->name; ?> : <?php echo $giftCard->description; ?>
										</div>
									</div>
									<div class="col" data-cols="1/3" data-medium-cols="1/3" data-small-cols="1/3" style="white-space:nowrap;">
										<div class="orderTotalsValue"><?php echo format_currency($giftCard->total_price); ?></div>
									</div>
								</div>
							<?php endforeach;?>
						<?php endif;?>

						<div class="col-nest">
							<div class="col" data-cols="2/3" data-medium-cols="2/3" data-small-cols="2/3">
								<div class="cartSummaryTotalsKey"><?php echo lang('grand_total');?>:</div>
							</div>
							<div class="col" data-cols="1/3" data-medium-cols="1/3" data-small-cols="1/3">
								<div class="orderTotalsValue"><?php echo format_currency($order->total);?></div>
							</div>
						</div>
						<div style="text-align:right; margin-bottom:10px;font-weight: 400;"><i>(Giá bán tại kho Tp.HCM, chưa bao gồm VAT)</i></div>
					</div>
				</div>

			<div class="col" data-cols="1/2">
				<div class="orderAddresses" style="margin-left:50px">
					<div class="orderAddressTitle"><b>Thông tin địa chỉ giao hàng</b><?php //echo lang('shipping_address');?></div>
					<div class="orderAddress">
						<div>
							<label>Tên liên hệ: </label>
							<?php echo $order->firstname ? $order->firstname : $order->shipping_firstname; ?>
						</div>
						<div>
							<label>Điện thoại: </label>
							<?php echo $order->phone ? $order->phone : $order->shipping_phone; ?>
						</div>
						<div>
							<label>Địa chỉ email: </label>
							<?php echo $order->email ? $order->email : $order->shipping_email; ?>
						</div>
						<div>
							<label>Địa chỉ giao hàng: </label>
							<?php echo $order->address1; ?>
							<p><i>Phường/Xã</i>: <?php echo $order->ward_name; ?></p>
							<p><i>Quận/Huyện</i>: <?php echo $order->district_name; ?></p>
							<p><i>TP/Tỉnh</i>: <?php echo $order->city_name; ?></p>
						</div>
						<div>
							<label>Ghi chú: </label>
							<?php echo $order->notes_customer; ?>
						</div>
					</div>
					<div class="hide">
						<div class="orderAddressTitle"><?php echo lang('billing_address');?></div>
						<div class="orderAddress">
						<?php echo format_address([
							'company'=>$order->billing_company,
							'firstname'=>$order->billing_firstname,
							'lastname'=>$order->billing_lastname,
							'phone'=>$order->billing_phone,
							'email'=>$order->billing_email,
							'address1'=>$order->billing_address1,
							'address2'=>$order->billing_address2,
							'city'=>$order->billing_city,
							'zone'=>$order->billing_zone,
							'zip'=>$order->billing_zip,
							'country_id'=>$order->billing_country_id
							]);?>
						</div>

						<div class="orderAddressTitle"><?php echo lang('payment_information');?></div>
						<div class="orderAddress">
							<?php foreach($order->payments as $payment):?>
							<div><?php echo $payment->description;?></div>
							<?php endforeach;?>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>