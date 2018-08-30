<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<div class="row">
	<?php echo form_open('cart/add-to-cart', 'id="add-to-cart"');?>
		<input type="hidden" name="cartkey" value="<?php echo CI::session()->flashdata('cartkey');?>" />
		<input type="hidden" name="id" value="<?php echo $id?>"/>
	</form>
	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
	<div class="layer_cart_product">
		<span class="title-modal">
			<i class="fa fa-check" aria-hidden="true"></i> Sản phẩm công thêm vào giỏ hàng của bạn
		</span>
		<div class="product-image-container layer_cart_img">
			<img class="layer_cart_img img-responsive" src="/themes/default/assets/images/product-1.jpg" alt="" title="">
		</div>
		<div class="layer_cart_product_info">
			<span class="name-product-pop"><?php echo $name;?></span>
			<div>
				<span>Số lượng</span>
				<span>1</span>
			</div>
			<?php $_price = get_price_sale($price_1, $saleprice_1);?>
			<div>
				<strong class="dark">Thành tiền</strong>
				<span class="product-price"><?php echo format_currency($_price['price']);?></span>
			</div>
		</div>
	</div>
	</div>
	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
	<div class="layer_cart_cart">
		<span class="title-modal1">
			<span>
				Hiện có <span id="totalItemsAddCart"><?php echo GC::totalItems();?></span> sản phẩm trong giỏ hàng.
			</span>
		</span>
		<!--
		<div class="layer_cart_row">
			<strong>Giá sản phẩm</strong>
			<span class="pink">2.400.000 VNĐ</span>
		</div>
		<div class="layer_cart_row">
			<strong>Tiền vận chuyễn</strong>
			<span class="pink">400.000 VNĐ</span>
		</div>
		-->
		<div class="layer_cart_row">
			<strong>Thành tiền</strong>
			<span class="pink"><?php echo format_currency(GC::getGrandTotal());?></span>
		</div>
		<div class="button-container">
			<button class="btn btn-default" title="" data-dismiss="modal">
				<span>
					<i class="icon-chevron-left left"></i>Tiếp tục mua hàng
				</span>
			</button>
			<a class="btn btn-default" href="/checkout" title="" rel="">
				<span>
					Thanh toán<i class="icon-chevron-right right"></i>
				</span>
			</a>
		</div>
	</div>
	</div>
</div>