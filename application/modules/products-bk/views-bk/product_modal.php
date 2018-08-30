<!-- modal quickview -->
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<div class="quick-view-wp product-detail-wp">
  <div class="row">
	<div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
	  <div class="slider-product-wp">
		<div class="gallery">
		  <div class="full"> 
			<img src="<?php echo get_image_primary_2($images);?>" /> 
		  </div>
		  <div class="clear"></div>
		  <div class="previews">
			<ul>
				<?php foreach($images as $key=>$image):?>
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
	<div class="col-lg-7 col-md-7 col-sm-6 col-xs-12">		
		<div class="des-product-wp">
			<?php echo form_open('cart/add-to-cart', 'id="add-to-cart"');?>
				<input type="hidden" name="cartkey" value="<?php echo CI::session()->flashdata('cartkey');?>" />
				<input type="hidden" name="id" value="<?php echo $id?>"/>
				<h3 class="title-des"><?php echo $name;?></h3>
				<?php if($quantity > 0){?><p class="status">Tình trạng : <span class="pink">Còn hàng</span></p><?php }?>
				<p class="status">Mã sản phẩm : <span class="pink"><?php echo $sku;?></span></p>
				<hr>
				<div class="product-price-block">
					<?php $_price = get_price_sale($price, $saleprice);?>
					<?php if($_price['sale']){?>
						<p class="product-price"><?php echo format_currency($_price['price']);?></p>
						<p class="product-price old"><?php echo format_currency($_price['price_old']);?></p>
					<?php }else{?>
						<p class="product-price"><?php echo format_currency($_price['price']);?></p>
					<?php }?>
				</div>
				<hr>
				<div id="productAlerts"></div>
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
					<?php echo $excerpt;?>
				</div>
			</form>
		</div>
	</div>
  </div>
</div>
<!-- end modal quickview -->