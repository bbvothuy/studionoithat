<?php 
	if(is_array($result)){
	  foreach($result as $product):
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
			</a>
		  </div>
		  <div class="media-body">
			<h5 class="media-heading"><?php echo $product->name; ?></h5>
			<p> </p>
			<span><?php echo format_currency(($product->saleprice_1 > 0) ? $product->saleprice_1 : $product->price_1);?></span>
		  </div>
		</div>
	
	<?php endforeach;?>
	<?php }else{?>
		<div class="cart-button">
			<button class="btn btn-danger form-control" style="color:white; background-color:#e91f6b">Chưa có sản phẩm</button>
		</div>
	<?php }?>
	
	<?php if($count_all_wishlist > 5){?>
	<div class="cart-button">
		<a href="#" class="btn btn-danger form-control" style="color:white; background-color:#e91f6b">Xem Tất Cả</a>
	</div>
	<?php }?>