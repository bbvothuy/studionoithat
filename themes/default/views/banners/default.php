<div class="sp-slides">
	<?php foreach($banners as $banner):
		$banner_image	= base_url('uploads/'.$banner->image);
	?>
	<div class="sp-slide">
		<?php if($banner->link){?>
		<a href="<?php echo $banner->link;?>" onclick="location.href='<?php echo $banner->link;?>'">
			<img alt="<?php echo $banner->name;?>" class="sp-image"
				data-src="<?php echo $banner_image;?>"
				data-retina="<?php echo $banner_image;?>"/>
		</a>
		<?php }else{?>
		<img alt="<?php echo $banner->name;?>" class="sp-image"
			data-src="<?php echo $banner_image;?>"
			data-retina="<?php echo $banner_image;?>"/>
		<?php }?>
	</div>
	<?php endforeach;?>	
</div>
<!--
<div class="sp-thumbnails">
	<?php foreach($banners as $banner):?>
	<div class="sp-thumbnail">
		<div class="sp-thumbnail-title"><?php echo $banner->name?></div>
		<div class="sp-thumbnail-description"><?php echo $banner->content ? $banner->content : '&nbsp;';?></div>
	</div>
	<?php endforeach;?>
</div>
-->